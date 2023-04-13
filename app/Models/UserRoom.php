<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
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
     * getRoom
     *
     * @return Room $Room
     */
    public function room()
    {
        return $this->belongsTo('App\Models\Room', 'room_id');
    }
}
