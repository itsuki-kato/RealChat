<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Repositories\MessageRepository;
use App\Events\ChatEvent;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct(
        private MessageRepository $messageRepository
    )
    {}

    /**
     * Chat画面の表示
     */
    public function index(int $room_id)
    {
        $Messages = $this->messageRepository->getMessages($room_id);

        return Inertia::render('ChatRoom', [
            'user_id' => Auth::user()->id,
            'room_id' => $room_id,
            'Messages' => $Messages
        ]);
    }

    /**
     * Messageの保存
     */
    public function store(Request $request)
    {
        $content = $request->get('content');
        $file = $request->file('file');
        $user_id = $request->get('user_id');
        $room_id = $request->get('room_id');

        // 新規メッセージの作成
        Log::info('[新規メッセージの作成開始]user_id:'.$user_id.','.'room_id:'.$room_id);

        $Message = $this->messageRepository->create($content, $file, $user_id, $room_id);

        Log::info('[新規メッセージの作成完了]id:'.$Message?->id);

        if(isset($Message)) {
            // リアルタイム化のためイベントを作成
            event(new ChatEvent($Message->id, $Message->content, $Message->user_id, $Message->room_id));
        } else {
            throw new NotFoundHttpException('新規メッセージが取得できませんでした。');
        }

        // chat画面にリダイレクト
        return to_route('chats.index', ['room_id' => $room_id]);
    }
}
