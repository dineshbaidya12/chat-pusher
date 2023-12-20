<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'first_user', 'second_user', 'status', 'requested_by', 'blocked_by', 'connected_from', 'blocked_time', 'last_message'
    ];

    public function messageDetails()
    {
        return $this->hasMany(Message::class, 'id', 'last_message');
    }

    public function firstUserDetails()
    {
        return $this->hasOne(User::class, 'id', 'first_user');
    }

    public function sedondUserDetails()
    {
        return $this->hasOne(User::class, 'id', 'second_user');
    }
}
