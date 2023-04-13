<?php

namespace App\Repositories;

use App\Models\Room;
use App\Models\UserRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRoomRepository
{
    /**
     * UserRoomの新規作成
     * NOTE：ユーザーがRoomに参加した時とRoomを作成した時に呼び出される。
     * 作成者(オーナー)は自動で参加者となる。
     *
     * @param integer $user_id
     * @param Room 　　$Room
     */
    public function create(int $user_id, Room $Room):void
    {
        UserRoom::create([
            'user_id' => $user_id,
            'room_id' => $Room->id 
        ]);

        Log::info('UserRoomの新規作成が完了しました。'.'user_id:'.$user_id.', room_id'.$Room->id);
    }
}
