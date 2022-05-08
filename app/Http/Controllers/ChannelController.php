<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Channel;
use App\Message;
// use App\Read;

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
        dd($channel);
    }

    public function delete(Request $request)
    {
        $channel = Channel::find($request->id);
        dd($channel);
    }

    public function add(Request $request)
    {
        $channel = Channel::find($request->id);
        $channel->users()->sync($request->user_id);
    }

    public function show($id,Request $request)
    {
        $channel = Channel::find($id);
        $channels = Auth::user()->channels;
        $directs = Auth::user()->directs;

        $page = $request->page;
        $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);
        
        if($session = $channel->messages()->orderBy('id', 'desc')->first()){
            session([$channel->name => $session->id]);
        }
            
        
        
        if($channel){
            return view('channel/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$id, 'messages'=>$messages, 'directs'=>$directs, 'page' => $page]);
        }else{
            abort(404);
        }
    }

    public function serch(Request $request)
    {
        // $channel = Channel::where('name', 'like', "%$request->text%")->get();
        // return response()->json($channel);

        $users = User::where('name', 'like', "%$request->text%")->where('id', '!=', Auth::user()->id)->get();
        
        return response()->json($users);
    }

    public function scroll_u(Request $request)
    {
        $channel = Channel::find($request->id);
        $point = Message::find($request->point_id);
        // $page = $request->page == 0 ? 2 : $request->page + 1;
        // $messages = $channel->messages()->orderBy('id', 'desc')->paginate(10, ['*'], 'page',$page);
        $messages = $channel->messages()->orderBy('id', 'desc')->get();
        // dd($point->id);
        $messages = $messages->filter(function($v,$k) use ($point){
            return $v->id < $point->id;
        })->take(10);
        $data = array();
        foreach($messages as $m){
            $name = $m->user->name;
            $d = $m->created_at->format('Y/m/d');
            $m = $m->toArray();
            $m = $m + array('name'=>$name,'data'=>$d);
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
        foreach($messages as $m){
            $name = $m->user->name;
            $d = $m->created_at->format('Y/m/d');
            $m = $m->toArray();
            $m = $m + array('name'=>$name,'data'=>$d);
            array_push($data,$m);
        }
        // dd($data);
        return response()->json($data);
    }

    public function jump(Request $request)
    {
        if($request->dm){
            $message = DirectMessage::find($request->id);
            $channel = $message->direct;
        }else{
            $message = Message::find($request->id);
            $id = $message->id;
            $channel = $message->channel;
            $test = collect(['a','b','c']);
            $messages = $channel->messages()->orderBy('id', 'desc')->get();
            $message = collect();
            
            foreach($messages as $m){
                
                if($m->id == $id){
                    $m = collect([$m]);
                    $message = $message->concat($m);
                    break;
                }else{
                    $m = collect([$m]);
                    $message = $message->concat($m);
                }
                // dd($m);
            }
            $channels = Auth::user()->channels;
            $directs = Auth::user()->directs;
            $page = $request->page;
            return view('jump/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$channel->id, 'messages'=>$message, 'directs'=>$directs, 'page' => $page]);
        }
        
    }
}
