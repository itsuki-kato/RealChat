<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Http\UploadedFile;
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
     * @param string  $detail
     * @param string  $file_name
     * @return Room $Room
     */
    public function createAndReturn(
        int $user_id, 
        string $name, 
        string $detail = null, 
        string $file_name = null
        ):Room
    {
        $Room = Room::create([
            'user_id' => $user_id,
            'name' => $name,
            'detail' => $detail,
            'file_path' => $file_name
        ]);

        Log::info('Roomの作成が完了しました。');

        return $Room;
    }
}
