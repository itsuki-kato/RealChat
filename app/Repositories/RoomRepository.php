<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomRepository
{
    /**
     * Roomの新規作成
     * NOTE：Roomの作成者はオーナーとなり、同時にUserRoomも作成するため、
     * 作成したRoomModelを返す
     *
     * @param integer $user_id
     * @param string  $name
     * @return Room $Room
     */
    public function createAndReturn(int $user_id, string $name):Room
    {
        $Room = Room::create([
            'name' => $name,
            'user_id' => $user_id
        ]);

        Log::info('Roomの作成が完了しました。');

        return $Room;
    }
}
