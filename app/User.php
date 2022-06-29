<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // public function reads()
    // {
    //     return $this->hasMany(Read::class);
    // }

    public function channels()
    {
        // Channel::class => ChannelClassを使う
        // channel_user => 中間テーブルの指定
        // user_id => 中間テーブルのこのカラムを探す
        // room_id => Channelテーブルをこのカラムで探索する
        return $this->belongsToMany(Channel::class, 'channel_user', 'user_id', 'room_id')
        ->withPivot('message_user','message_id');
    }

    public function directs()
    {
        return $this->belongsToMany(Direct::class, 'direct_user', 'user_id', 'room_id')
        ->withPivot('message_user','message_id');
    }

    public function direct_messages()
    {
        return $this->belongsToMany(DirectMessage::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($data){
            $data->directs()->delete();
        });
    }
}

