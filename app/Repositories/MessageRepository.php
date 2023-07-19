<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository
{
    /**
     * Roomごとのメッセージの取得
     *
     * @param integer $room_id
     * @return Collection $Messeages
     */
    public function getMessages(int $room_id)
    {
        $Messages = Message::where('room_id', '=', $room_id)
            ->with('user')
            ->get();

        return $Messages;
    }

    /**
     * Messageの保存
     *
     * @param string|null $send_message
     * @param UploadedFile|null $send_file // 未実装
     * @param integer $user_id
     * @param integer $room_id
     * @return void
     */
    public function create(
        string $send_message=null, 
        UploadedFile $send_file=null,
        int $user_id,
        int $room_id
    )
    {
        Message::create([
            'user_id' => $user_id,
            'room_id' => $room_id,
            'content' => $send_message    
        ]);
    }
}
