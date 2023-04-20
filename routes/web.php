<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile',    [ProfileController::class, 'edit'])      ->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])    ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])   ->name('profile.destroy');
    
    // UserRooms
    Route::get('/', [RoomController::class, 'userIndex'])->name('user_rooms.index'); // 一覧表示
    
    // Rooms
    Route::get('/rooms',                [RoomController::class, 'index'])  ->name('rooms.index');   // 一覧表示
    Route::get('/rooms/create',         [RoomController::class, 'create']) ->name('rooms.create');  // 新規作成画面表示
    Route::post('/rooms/store',         [RoomController::class, 'store'])  ->name('rooms.store');   // 新規作成
    Route::get('/rooms/{room_id}/edit', [RoomController::class, 'edit'])   ->name('rooms.edit');    // 編集画面表示
    Route::put('/rooms/update',         [RoomController::class, 'update']) ->name('rooms.update');  // 編集保存
    Route::delete('/rooms/{room_id}',   [RoomController::class, 'destroy'])->name('rooms.destroy'); // 削除

    // Chats
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');   // 一覧表示
});

require __DIR__.'/auth.php';
