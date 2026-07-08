<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getallusers()
    {
        
        $allusers=Cache::remember("AllUsers_page",3600,function(){
            return User::Paginate(10);
    });
        return response()->json([
            'message'=>'All users',
            'data'=>$allusers
        ],200);
    }

    
}
