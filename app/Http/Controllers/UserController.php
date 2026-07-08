<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getallusers()
    {
        //default number for the page is one, but if user enters any number it will be accepted
        $page=request('page',1);
        $allusers=Cache::remember("AllUsers_page",3600,function(){
            return User::Paginate(10);
    });
        return response()->json([
            'message'=>'All users',
            'data'=>$allusers
        ],200);
    }
    public function destroy(string $id){
        $user=User::findOrFail($id);
        $user->delete();
        Cache::forget("AllUsers_page");
        return response()->json([
            'message'=>'user deleted successfully.'
        ],200);
    }

    
}
