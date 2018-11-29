{{$user->user}}님 환영합니다.
가입 확인을 위해 다음 링크를 열어주세요.
{{route('users.confirm',$user->confirm_code)}}