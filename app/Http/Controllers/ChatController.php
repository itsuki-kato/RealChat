<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Repositories\MessageRepository;

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
        $send_message = $request->get('send_message');
        $send_file = $request->file('send_file');
        $user_id = $request->get('send_user_id');
        $room_id = $request->get('send_room_id');

        $this->messageRepository->create($send_message, $send_file, $user_id, $room_id);

        // chat画面にリダイレクト
        return to_route('chats.index', ['room_id' => $room_id]);
    }
}
