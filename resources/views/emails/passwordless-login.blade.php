<!DOCTYPE html>
<html>
<head>
    <title>Malla Treks</title>
</head>
<body>
    <div>
        <div style="width: 364px; height:200px">
            
            <img src="<?php echo $message->embed($data['logo']); ?>" style="height: 100%; width:100%" alt="">
            {{-- <img src="{{ asset('assets/img/logos/app.png') }}" style="height: 100%; width:100%" alt=""> --}}
        </div>
    </div>
    <h1>Login</h1>
    <p> Hey there! </p>
    <p>   It looks like you are trying to access your account. </p>
  
    <p>    <a class="btn btn-primary" href="{{ $data['link'] }}">Click here</a> to login.</p>
    <p>   This link will be valid for a day. </p>
     
    <p>Thank you</p>
</body>
</html>