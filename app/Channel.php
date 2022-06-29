<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    //
    protected $guarded = ['id'];

    public function messages()
    {
        return $this->hasMany(Message::class, 'room_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'channel_user', 'room_id', 'user_id')
        ->withPivot('message_user','message_id');
    }

    // public function reads()
    // {
    //     return $this->hasMany(Read::class);
    // }

    public static function boot()
    {
        // parentは親クラスの同名メソッドを呼び出す
        parent::boot();

        // bootはElequent初回起動時に呼ばれる
        // Channel削除時にMessageも削除
        static::deleting(function($data){
            $data->messages()->delete();
        });
    }
}
