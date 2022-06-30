<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Direct;
use App\Channel;
use App\DirectMessage;
use App\DirectUser;
use Illuminate\Routing\Route;

class DirectController extends Controller
{
    
    public function create(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        $directs = $user->directs()->get();
        $bool = true;


        
        // 同じユーザーをDMに登録しないようにしている
        foreach($directs as $d){
            foreach($d->users as $u){
                if($id == $u->id){
                    $bool = false;
                    break;
                }
            }
        }
        if($bool){
            $direct = new Direct();
            $direct->save();
            $direct->users()->attach($id);
            $direct->users()->attach(Auth::user()->id);
            // dd($direct->users);

            // DMのURLと登録した相手の名前を返す
            $url = action('DirectController@show',$direct->id);
            $return = ["url" => $url, "user" => User::find($id)->name];
            return response()->json($return);
        }
        
        return response()->json($request->id);
    }

    public function delete(Request $request)
    {
        $direct = Direct::find($request->id);
        $direct->delete();

        return redirect()->action('ChannelController@show',['id'=>1]);
    }

    public function serch(Request $request)
    {
        
        
        // 自分とつながっているDMをすべて取得
        $directs = Auth::user()->directs;
        $direct_users = [];
        $myId = [Auth::user()->id];
        foreach($directs as $d){
            $direct_users = array_merge($direct_users,$d->users->pluck('id')->toArray());
        }
        
        
        // 自分とつながっているDMを含まないユーザーを検索
        $users = User::where('name', 'like', "%$request->text%")->whereNotIn('id', $myId)->whereNotIn('id',$direct_users)->get();
        
        // dd($users);
        // echo $users;
        // $users->find(Auth::user()->id)
        return response()->json($users);
    }

    public function show($id){
        // dd(1001);
        
        $direct = Direct::find($id);

        // 通信相手の名前を取得している
        $room_name = $direct->users->where('id', '!=', Auth::user()->id)->first()->name;
        
        
        $messages = $direct->direct_messages()->orderBy('id', 'desc')->get()->take(-10);


        // 未読通知のため中間テーブルを取得している
        $direct_user = DirectUser::where('user_id', '=', Auth::user()->id)->where('room_id', '=', $id)->first();
        
        if($direct){
            if($last_message = $direct->direct_messages()->orderBy('id', 'desc')->first()){
                // dd($direct->users);
                $direct_user->message_user = $last_message->user->id;
                $direct_user->message_id = $last_message->id;
                $direct_user->update();
            }
            // pivotはhasManyなど中間テーブルを使用して取得したオブジェクトじゃないと使えない
            // 取得したタイミングに依存するため$direct_user->update();より後に取得する必要がある
            $channels = Auth::user()->channels()->get();
            $directs = Auth::user()->directs()->get();

            // socket.ioに渡すdirectControllerである識別子
            $room_type = "d";

            return view('direct/show',['room_name'=>$room_name, 'channels'=>$channels,'id'=>$id, 'messages'=>$messages, 'directs'=>$directs, 'room_type'=>$room_type]);
            // return view('channel/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$id, 'messages'=>$messages, 'directs'=>$directs]);
        }else{
            abort(404);
        }
    }

    public function scroll_u(Request $request)
    {

        // dd(100);

        $channel = Direct::find($request->id);
        $point = DirectMessage::find($request->point_id);
        // $page = $request->page == 0 ? 2 : $request->page + 1;
        // $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);

        // 全部のメッセージを取得
        $messages = $channel->direct_messages()->orderBy('id', 'desc')->get();
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

        // dd(100);

        $channel = Direct::find($request->id);
        $point = DirectMessage::find($request->point_id);
        // $page = $request->page == 0 ? 2 : $request->page + 1;
        // $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);
        $messages = $channel->direct_messages()->get();
        // dd($point->id);
        $messages = $messages->filter(function($v,$k) use ($point){
            return $v->id > $point->id;
        })->take(10);
        $data = array();
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
}
