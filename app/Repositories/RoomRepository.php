<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomRepository
{
    /**
     * 自身が参加していないRoomを取得する
     * NOTE：Vue表示用に親テーブルも取得する
     *
     * @param integer $user_id
     * @return Collection $Rooms
     */
    public function findWithoutUserRoom(int $user_id):Collection
    {
        $Rooms =
            Room::join('user_rooms', function ($join) {
                $join->on('rooms.user_id', '=', 'user_rooms.user_id');
            })
            ->where('user_rooms.user_id', '!=', DB::raw('?'))
            // 同じuser_idが複数あるため重複したレコードが取得されるためdistinct
            ->distinct()
            ->select('rooms.*')
            ->with('user')
            ->setBindings([$user_id])
            ->get();

        return $Rooms;
    }

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
    public function createAndGet(
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
