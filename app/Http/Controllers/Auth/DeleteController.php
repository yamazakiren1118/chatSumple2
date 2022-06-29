<?php
//namespaceを変更
namespace App\Http\Controllers\Auth;

//controllerをサブディレクトリに作るときは以下を追加
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\User;

class DeleteController extends Controller
{
    //
    
    public function delete(Request $request)
    {
        // dd(100);
        $user = User::find($request->id);
        $user->delete();

        return redirect()->action('ChannelController@show',['id'=>1]);
    }
}
