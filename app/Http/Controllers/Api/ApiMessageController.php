<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Repositories\MessageRepository;
use App\Events\ChatEvent;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ApiMessageController extends Controller
{
    public function __construct(
        private MessageRepository $messageRepository
    )
    {}

    /**
     * room_idに紐づくMessageの全件取得
     */
    public function get($room_id)
    {
        // $Messages = $this->messageRepository->getMessages($request->query('room_id'));

        // return to_route('chats.index', ['room_id' => $room_id]);
        return response()->json(['message' => 'hello']);
    }

    /**
     * Messageの保存
     */
    public function store(Request $request)
    {
        $send_message = $request->get('send_message');
        $send_file = $request->file('send_file');
        $user_id = $request->get('send_user_id');
        $room_id = $request->get('send_room_id');

        $this->messageRepository->create($send_message, $send_file, $user_id, $room_id);

        // リアルタイム化のためイベントリスナーを呼び出し
        event(new ChatEvent($send_message, $user_id, $room_id));

        // chat画面にリダイレクト
        return to_route('chats.index', ['room_id' => $room_id]);
    }
}
