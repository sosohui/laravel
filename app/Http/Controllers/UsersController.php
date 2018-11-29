<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;

class UsersController extends Controller
{
    //
    public function __construct(){
        //guest만 이 함수를 호출할 수 있다.(=로그인 하지 않은 사용자)
        return $this->middleware('guest');
    }

    //사용자 등록 생성 폼
    public function create() {
        return view('users.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $confirmCode = str_random(60);

        $user = \App\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode
        ]);


        \Mail::send('emails.auth.confirm',compact('user'),function($message) use($user){
            $message->to($user->email);
            $message->subject("게시판 회원 가입 확인");
        });
        flash('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해 주세요.');

        return redirect('bbs');
    }

    public function confirm($code){
        //1.code값을 가지는 레코드를 찾는다. users테이블에서
        //2.레코드가 없으면 회원가임 페이지로 redirect
        //3.그 레코드의 activated 값으로 1로 변경하고
        //4.confirm_code를 null로 변경
        //5.db에 저장
        //6.로그인
        //7.main페이지로 redirection
        $user = User::whereConfirmCode($code)->first();
        if(!$user){
            flash('가입 확인 실패! 잘못된 정보 입니다.');
            return redirect(route('users.create'));
        }
        $user->activated = 1;
        $user ->confirm_code = null;
        $user->save();

        Auth::login($user);
        flash($user->name.'님 환영합니다. 가입 확인되었습니다.');
        return redirect(route('/'));
    }
}
