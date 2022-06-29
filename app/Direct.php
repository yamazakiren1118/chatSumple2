<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direct extends Model
{
    //
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'direct_user', 'room_id', 'user_id')
        ->withPivot('message_user','message_id');
    }

    public function direct_messages()
    {
        return $this->hasMany(DirectMessage::class, 'room_id');
    }

    public static function boot()
    {
        parent::boot();

        // DM削除時にメッセージも削除
        static::deleting(function($data){
            $data->direct_messages()->delete();
        });
    }
}
