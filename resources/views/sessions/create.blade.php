@extends('layouts.template')

@section('content')
    <form action="{{ route('sessions.store') }}" method="POST" class="form__auth">
        {!! csrf_field() !!}

        
        <div class="form-group row">
            <label for="email"
                   class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email"
                       class="form-control"
                       name="email" value="{{ old('email') }}" required autofocus>

                {!! $errors->first('email','<span class="form-error">:message</span>') !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="password"
                   class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password"
                       class="form-control"
                       name="password" required>

                {!!  $errors->first('password','<span class="form-error">:message</span>') !!}

            </div>
        </div>
        <input type="submit" value="login">
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="{{ old('remember',1) }}">
                    로그인 기억하기 <span class="text-danger">공용 컴퓨터에서는 사용하지 마세요!</span>
                </label>
            </div>
        </div>

        <div>
            <p class="text-center">회원이 아니라면?
                <a href="{{ route('users.create') }}">가입하세요.</a>
            </p>
           
        </div>
    </form>            
@stop