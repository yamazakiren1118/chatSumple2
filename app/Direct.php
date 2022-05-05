<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direct extends Model
{
    //
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function direct_messages()
    {
        return $this->hasMany(DirectMessage::class);
    }
}
