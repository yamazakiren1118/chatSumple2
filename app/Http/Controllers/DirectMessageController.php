<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\DirectMessage;

class DirectMessageController extends Controller
{
    //
    public function create(Request $request)
    {
        $message = new DirectMessage();
        $message->fill($request->all());
        $message->user_id = Auth::user()->id;
        $message->save();
        return redirect(url()->previous());
    }

    public function delete()
    {
        
    }

    public function edit(Request $request)
    {
        $message = DirectMessage::find($request->id);
        return $message->message;
    }

    public function update(Request $request)
    {
        $message = DirectMessage::find($request->id);
        $id = $message->direct_id;
        // dd($message);
        $message->fill($request->all());
        $message->update();
        return redirect()->action('DirectController@show',['id' => $id]);
    }
}
