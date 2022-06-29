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
        // dd($message);
        $message->save();
        
        // ユーザーidを取得してusersというカラムを追加
        $users = $message->direct->users->pluck("id")->toArray();
        $message->users = $users;

        return response()->json($message);
    }

    public function delete(Request $request)
    {
        $message = DirectMessage::find($request->id);
        $id = $message->room_id;
        // dd($message);
        $message->delete();
        return redirect()->action('DirectController@show',['id' => $id]);
        
    }

    public function edit(Request $request)
    {
        $message = DirectMessage::find($request->id);
        return $message->message;
    }

    public function update(Request $request)
    {
        $message = DirectMessage::find($request->id);
        $id = $message->room_id;
        
        $message->fill($request->all());
        $message->update();
        return redirect()->action('DirectController@show',['id' => $id]);
    }


    public function socket_serch(Request $request)
    {
        $id = $request->id;
        $message = DirectMessage::find($id);
        $user = $message->user;
        $update_url = action('DirectMessageController@update');
        $edit_url = action('DirectMessageController@edit');
        $delete_url = action('DirectMessageController@delete');

        $response = array('id' => $id,
                        'user_name' => $user->name,
                        'user_id' => $user->id,
                        'updated_at' => $message->updated_at->format('Y/m/d'),
                        'message' => $message->message,
                        'update_url' => $update_url,
                        'edit_url' => $edit_url,
                        'delete_url' => $delete_url);
        return response()->json($response);
    }
}
