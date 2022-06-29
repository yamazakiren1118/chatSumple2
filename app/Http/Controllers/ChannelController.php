<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Channel;
use App\Message;
use App\ChannelUser;
use App\Direct;
use App\DirectMessage;

class ChannelController extends Controller
{
    //
    public function index(Request $request)
    {
        
    }

    public function create(Request $request)
    {
        $channel = new Channel();
        $channel->fill($request->all());
        $channel->save();
        $channel->users()->attach(Auth::user()->id);
        // dd($channel);


        $response = ['url' => action('ChannelController@show',$channel->id), 'name' => $channel->name];
        return response()->json($response);
        // dd($channel);
    }

    public function delete(Request $request)
    {
        $channel = Channel::find($request->id);
        $channel->delete();

        return redirect()->action('ChannelController@show',['id'=>1]);
    }

    public function add(Request $request)
    {
        $channel = Channel::find($request->id);

        // 三項演算子でユーザーを追加とチャンネルを追加の処理を分けている
        $user_id = $request->user_id == 'my' ? Auth::user()->id : $request->user_id;
        $channel->users()->syncWithoutDetaching($user_id);
        $return = ['url' => action('ChannelController@show',$channel->id), 'name' => $channel->name];

        // dd($channel->users);
        return response()->json($return);
    }

    // チャンネルから脱退させる
    public function detach(Request $request)
    {
        $channel = Channel::find($request->id);
        if($request->id != 1){
            $channel->users()->detach(Auth::user()->id);
        }

        // トップページにリダイレクト
        return redirect()->action('ChannelController@show',['id'=>1]);
    }

    public function show($id,Request $request)
    {
        $channel = Channel::find($id);
        


        
        // 中間テーブルを取得
        $channel_user = ChannelUser::where('user_id', '=', Auth::user()->id)->where('room_id', '=', $id)->first();

        
        if($channel && $channel_user){
            $page = $request->page;
            $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);
            
            // dd($channel_user);
            // 最新のメッセージのidと投稿者を保存
            // dd($directs[0]->users[0]->pivotcc);
            
            
            
            if($last_message = $channel->messages()->orderBy('id', 'desc')->first()){
                $channel_user->message_user = $last_message->user->id;
                $channel_user->message_id = $last_message->id;
                $channel_user->update();
            }
            // dd($channel->messages()->orderBy('id', 'desc')->first());
            $channels = Auth::user()->channels;
            $directs = Auth::user()->directs;

            // socket.ioに渡すchannelControllerであることを示す識別子
            $room_type = "c";
            return view('channel/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$id, 'messages'=>$messages, 'directs'=>$directs, 'page' => $page, 'room_type' => $room_type]);
        }else{
            abort(404);
        }
    }

    public function serch(Request $request)
    {
        $my_channels = Auth::user()->channels->pluck('id')->toArray();
        $channels = Channel::where('name', 'like', "%$request->text%")->whereNotIn('id',$my_channels)->get();
        // dd($channels);
        return response()->json($channels);
    }

    // チャンネルに追加するためユーザーを検索するときのアクション
    public function user_serch(Request $request){
        $channel_users = Channel::find($request->url_id)->users()->get();


        $users = User::where('name', 'like', "%$request->text%")
        ->where('id', '!=', Auth::user()->id)->get();

        $users = $users->filter(function($v,$k) use ($channel_users){
            return $channel_users->where('id', '==', $v->id)->count() <= 0;
        });
        
        return response()->json($users);
    }

    public function scroll_u(Request $request)
    {
        $channel = Channel::find($request->id);
        $point = Message::find($request->point_id);
        // $page = $request->page == 0 ? 2 : $request->page + 1;
        // $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);

        // 全部のメッセージを取得
        $messages = $channel->messages()->orderBy('id', 'desc')->get();
        // dd($point->id);

        // 最新のメッセージよりもidが小さいものを選別している
        $messages = $messages->filter(function($v,$k) use ($point){
            return $v->id < $point->id;
        })->take(10);
        $data = array();

        // jsで処理するために日付とかを取得している
        foreach($messages as $m){
            $name = $m->user->name;
            $d = $m->created_at->format('Y/m/d');
            $user_id = $m->user->id;
            $m = $m->toArray();
            $m = $m + array('name'=>$name,'data'=>$d,'user_id'=>$user_id);
            array_push($data,$m);
        }
        // dd($data);
        return response()->json($data);
    }

    public function scroll_d(Request $request)
    {
        $channel = Channel::find($request->id);
        $point = Message::find($request->point_id);
        // $page = $request->page == 0 ? 2 : $request->page + 1;
        // $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);
        $messages = $channel->messages()->get();
        // dd($point->id);
        $messages = $messages->filter(function($v,$k) use ($point){
            return $v->id > $point->id;
        })->take(10);
        $data = array();

        // メッセージを取得する際に配列にした後日付情報やユーザー名などをその配列に追加している
        foreach($messages as $m){
            $name = $m->user->name;
            $d = $m->created_at->format('Y/m/d');
            $user_id = $m->user->id;
            $m = $m->toArray();
            $m = $m + array('name'=>$name,'data'=>$d,'user_id'=>$user_id);
            array_push($data,$m);
        }
        // dd($data);
        return response()->json($data);
    }

    // メッセージを検索したときにリンクさせるための処理
    public function jump(Request $request)
    {
        // dd($request->dm);
        if($request->dm){
            $message = DirectMessage::find($request->id);
            $id = $message->id;
            $channel = $message->direct;
            $messages = $channel->direct_messages()->orderBy('id', 'desc')->get();
            $message = $messages->filter(function($i) use ($id){
                return $i->id >= $id;
            })->take(-10);
            $channels = Auth::user()->channels;
            $directs = Auth::user()->directs;
            $page = $request->page;
            return view('jump/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$channel->id, 'messages'=>$message, 'directs'=>$directs, 'page' => $page, 'direct'=>'direct_scroll']);
        }else{
            
            $message = Message::find($request->id);
            $id = $message->id;
            $channel = $message->channel;
            // $test = collect(['a','b','c']);

            // クリックしたメッセージよりも大きい=最新のメッセージを取得して後ろから10件取得
            // これにより一番後ろがクリックしたメッセージのものが10件取得できる
            $messages = $channel->messages()->orderBy('id', 'desc')->get();
            $message = $messages->filter(function($i) use ($id){
                return $i->id >= $id;
            })->take(-10);
            // $message = collect();
            
            // foreach($messages as $m){
                
            //     if($m->id == $id){
            //         $m = collect([$m]);
            //         $message = $message->concat($m);
            //         break;
            //     }else{
            //         $m = collect([$m]);
            //         $message = $message->concat($m);
            //     }
            //     // dd($m);
            // }

            
            $channels = Auth::user()->channels;
            $directs = Auth::user()->directs;
            $page = $request->page;
            return view('jump/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$channel->id, 'messages'=>$message, 'directs'=>$directs, 'page' => $page]);
        }
        
    }
}
