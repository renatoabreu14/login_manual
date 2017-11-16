<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirect(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('facebook')->user();
        return response()->json($user);
    }
}
