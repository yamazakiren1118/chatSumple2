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
        
        
        // ユーザーidを取得してusersというカラムを追加
        $users = $message->channel->users->pluck("id")->toArray();
        $message->users = $users;
        

        return response()->json($message);
        
        // 未読通知のための処理
        // $channel = Channel::find($request->room_id);
        // $users_id = $channel->users()->get();

        
        // foreach($users_id as $user){
        //     $read = new Read();
        //     $read->user_id = $user->id;
        //     $read->room_id = $channel->id;
        //     $read->read = false;
        //     $read->save();
        // }
        
    }

    public function delete(Request $request)
    {
        $message = Message::find($request->id);
        $id = $message->room_id;
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
        $id = $message->room_id;
        $message->fill($request->all());
        $message->update();
        return redirect()->action('ChannelController@show',['id' => $id]);
    }



    // メッセージをチャンネル、DM混同で検索する
    public function serch(Request $request)
    {
        $channels_id = Auth::user()->channels->pluck('id')->toArray();
        $directs_id = Auth::user()->directs->pluck('id')->toArray();

        // dd($channels_id);
        // 自分が所属するルームに投稿されたメッセージしか検索対象にしない
        $messages = Message::whereIn('room_id',$channels_id)->where('message', 'like', "%$request->text%")->get();
        // dd(get_class($messages[0]));
        $d_messages = DirectMessage::whereIn('room_id',$directs_id)->where('message', 'like', "%$request->text%")->get();
        $channels = Auth::user()->channels;
        $directs = Auth::user()->directs;
        
        // DMの検索結果と普通のメッセージの検索結果を１つのコレクションにまとめる
        $messages = $messages->concat($d_messages);
        // dd($messages[0] instanceof Message);
        // return view('message/show',['id'=>$request->text, 'channels'=>$channels,'messages'=>$messages, 'd_messages'=>$d_messages, 'directs'=>$directs]);
        
        return view('message/show',['id'=>$request->text, 'channels'=>$channels,'messages'=>$messages, 'directs'=>$directs]);

    }

    // socket.ioからAjax経由でメッセージ情報を取得する
    // jsで処理するために必要な投稿者名やリンク情報を返す
    public function socket_serch(Request $request)
    {
        $id = $request->id;
        $message = Message::find($id);
        $user = $message->user;
        $update_url = action('MessageController@update');
        $edit_url = action('MessageController@edit');
        $delete_url = action('MessageController@delete');

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
