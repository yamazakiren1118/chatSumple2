<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\Read;
use App\User;
use App\Channel;
use App\DirectMessage;

class MessageController extends Controller
{
    //
    public function create(Request $request)
    {
        $message = new Message();
        $message->fill($request->all());
        $message->user_id = Auth::user()->id;
        
        $message->save();
        
        // 未読通知のための処理
        // $channel = Channel::find($request->channel_id);
        // $users_id = $channel->users()->get();

        
        // foreach($users_id as $user){
        //     $read = new Read();
        //     $read->user_id = $user->id;
        //     $read->channel_id = $channel->id;
        //     $read->read = false;
        //     $read->save();
        // }
        
    }

    public function delete(Request $request)
    {
        $message = Message::find($request->id);
        $id = $message->channel_id;
        // dd($message);
        $message->delete();
        return redirect()->action('ChannelController@show',['id' => $id]);
    }

    public function edit(Request $request)
    {
        $message = Message::find($request->id);
        return $message->message;
    }

    public function update(Request $request)
    {
        $message = Message::find($request->id);
        $id = $message->channel_id;
        $message->fill($request->all());
        $message->update();
        return redirect()->action('ChannelController@show',['id' => $id]);
    }



    public function serch(Request $request)
    {
        $messages = Message::where('message', 'like', "%$request->text%")->get();
        // dd(get_class($messages[0]));
        $d_messages = DirectMessage::where('message', 'like', "%$request->text%")->get();
        $channels = Auth::user()->channels;
        $directs = Auth::user()->directs;
        
        $messages = $messages->concat($d_messages);
        // dd($messages[0] instanceof Message);
        // return view('message/show',['id'=>$request->text, 'channels'=>$channels,'messages'=>$messages, 'd_messages'=>$d_messages, 'directs'=>$directs]);
        
        return view('message/show',['id'=>$request->text, 'channels'=>$channels,'messages'=>$messages, 'directs'=>$directs]);

    }

}
