<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialController extends Controller
{
    //
    public function redirectToProvider(){
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback(){
        $user = Socialite::driver('github')->user();

        $user = (User::whereEmail($user->getEmail())->first())?:User::create([
            'name' => $user->getName()?:'이름을 추가해주세요.',
            'email' => $user->getEmail(),
            'acivated'=>1,
        ]);

        auth()->login($user);

        flash(auth()->user()->name.'님 환영합니다.');
        return redirect('/');
    }
}
