<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    //
    protected $guarded = ['id'];

    public function direct()
    {
        return $this->belongsTo(Direct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
