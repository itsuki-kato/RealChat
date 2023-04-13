<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    /**
     * getUser
     *
     * @return User $User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * getUserRoom
     *
     * @return UserRoom[] $UserRooms
     */
    public function UserRooms()
    {
        return $this->hasMany('App\Models\UserRoom');
    }

    /**
     * getMessage
     *
     * @return Message[] $Messages
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
}
