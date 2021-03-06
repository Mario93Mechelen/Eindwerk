<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Semestr</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="login_page_wrapper" style="background-image: url('img/landing-banner-mobile.jpg')">

    <div class="login_page">
        <img class="main_logo" alt="Semestr logo" src="{{url('img/Semestr_logo1_whitetext.png')}}">

        <div class="login-page-center">

            <form class="login-form" method="post" action="{{URL::action('Auth\LoginController@login')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" class="form-control" id="email_login" name="email" placeholder="email">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" class="form-control" id="password_login" name="password" placeholder="password">
                </div>
                <button type="submit" class="btn btn-primary">login</button>
            </form>
            @if($errors->any())
                <h4 class="error1">{{$errors->first()}}</h4>
            @endif

            <div class="fb-login-intro"><span>or login with</span></div>
            <a class="btn btn-primary social_login facebook_login" href="/login/facebook">facebook</a>
            <div class="login-to-signup">don't have an account yet? <a href="{{URL::action('Auth\RegisterController@index')}}">Sign up!</a></div>

        </div>
    </div>

</body>
</html>