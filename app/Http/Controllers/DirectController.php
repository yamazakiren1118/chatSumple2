<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Direct;

class DirectController extends Controller
{
    //
    public function create(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        $directs = $user->directs()->get();
        $bool = true;
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
            return response()->json($direct);
        }
        
        return response()->json($request->id);
    }

    public function delete()
    {
        
    }

    public function serch(Request $request)
    {
        $users = User::where('name', 'like', "%$request->text%")->where('id', '!=', Auth::user()->id)->get();
        // echo $users;
        // $users->find(Auth::user()->id)
        return response()->json($users);
    }

    public function show($id){
        
        $direct = Direct::find($id);
        $directs = Auth::user()->directs()->get();
        $messages = $direct->direct_messages()->get();
        $channels = Auth::user()->channels()->get();
        // dd($channels);
        if($direct){
            
            return view('direct/show',['channel'=>$direct, 'channels'=>$channels,'id'=>$id, 'messages'=>$messages, 'directs'=>$directs]);
            // return view('channel/show',['channel'=>$channel, 'channels'=>$channels,'id'=>$id, 'messages'=>$messages, 'directs'=>$directs]);
        }else{
            abort(404);
        }
    }
}
