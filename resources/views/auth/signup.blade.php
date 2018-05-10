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

            <form class="login-form">
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" class="form-control" id="email_register" name="email" placeholder="email">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" class="form-control" id="password_register" name="password" placeholder="password">
                </div>
                <div class="form-group">
                    <label for="password_repeat">password repeat</label>
                    <input type="password_repeat" class="form-control" id="password_repeat_register" name="password_repeat"
                           placeholder="password repeat">
                </div>
                <button type="submit" class="btn btn-primary">next</button>
            </form>

            <div class="fb-login-intro"><span>or register with</span></div>
            <a class="btn btn-primary social_login facebook_login" href="/login/facebook">facebook</a>

        </div>
    </div>

</body>
</html>