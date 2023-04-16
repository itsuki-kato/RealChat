<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Room\RoomUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Room;
use App\Models\UserRoom;
use App\Repositories\RoomRepository;
use App\Repositories\UserRoomRepository;
use Exception;

class RoomController extends Controller
{
    public function __construct(
        private RoomRepository $roomRepository,
        private UserRoomRepository $userRoomRepository,
    )
    {}

    /**
     * Roomの一覧表示(UserRoom以外)
     */
    public function index(Request $request)
    {
        return Inertia::render('Rooms');
    }

    public function userIndex()
    {
        // 一覧表示用にuser_idに紐づくUserRoomを全件取得する
        $UserRooms = $this->userRoomRepository->findAllWithParent(Auth::user()->id);

        return Inertia::render('UserRooms', ['UserRooms' => $UserRooms]);
    }

    /**
     * Roomの新規作成画面表示
     */
    public function create(Request $request)
    {
        return Inertia::render('CreateRoom');
    }

    /**
     * Roomの新規作成
     */
    public function store(RoomUpdateRequest $request)
    {   
        // RoomUpdateRequestのバリデーションを通過した場合
        // 作成するRoom名をformから取得
        $name = $request->get('name');

        try 
        {
            DB::beginTransaction();
            // オーナーは自動でRoomに参加するため、UserRoomも同時作成する
            $Room = $this->roomRepository->createAndReturn(Auth::user()->id, $name);
            $this->userRoomRepository->create(Auth::user()->id, $Room);

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            Log::error('Roomが新規作成できませんでした。user_id:'.Auth()->user->id);

            throw new \Exception($e);
        }

        return to_route('user_rooms.index')->with('message', 'success!!');
    }

    /**
     * Roomの編集画面表示
     */
    public function edit($id)
    {
        return to_route('/');
    }

    /**
     * Roomの編集保存
     */
    public function update(Request $request)
    {
        return to_route('/');
    }

    /**
     * Roomの削除
     */
    public function destroy($id)
    {
        return to_route('/');
    }
}
