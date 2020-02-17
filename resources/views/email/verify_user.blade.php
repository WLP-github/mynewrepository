<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome Email</title>
</head>
<body>
    <h2>Welcome - {{$user['name']}}</h2>
    <br/>
    Your registered email is {{$user['email']}} ,
    <br>Your password is <strong>{{$str_pass}}</strong> ,
   
    @if (strpos(url()->current(), 'sign-up') !== false)

        <br> Please click on the following link to activate your account.
        <br/>
        <a href="{{ url('user/activation', $user['link']) }}">Click to verify your email</a>
        
    @endif

</body>
</html>