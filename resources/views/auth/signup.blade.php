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

            <form class="login-form " method="post" action="{{URL::action('Auth\RegisterController@register')}}">
                {{ csrf_field() }}
                <div class="step1">
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
                    <input type="password" class="form-control" id="password_repeat_register" name="password_repeat"
                           placeholder="password repeat">
                </div>
                    <p class="error1" style="color:red;"></p>
                <button class="btn btn-primary to-step-2">next</button>
                </div>
                <div class="step2">
                <div class="form-group">
                    <label for="firstname">first name</label>
                    <input type="text" class="form-control" id="firstname_register" name="firstname" placeholder="first name">
                </div>
                <div class="form-group">
                    <label for="lastname">last name</label>
                    <input type="text" class="form-control" id="lastname_register" name="lastname" placeholder="last name">
                </div>
                <button type="submit" class="btn btn-primary">register</button>
                </div>

            </form>

            <div class="fb-login-intro"><span>or register with</span></div>
            <a class="btn btn-primary social_login facebook_login" href="/login/facebook">facebook</a>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $('.step2').hide();
        $('.to-step-2').on('click', function(e){
            e.preventDefault();
            if($('#email_register').val() != "" && $('#email_register').val().indexOf('@')>0 && $('#email_register').val().indexOf('.')>0 && $('#email_register').val().indexOf('@')< $('#email_register').val().indexOf('.')) {
                if($('#password_register').val() != "" && $('#password_register').val() == $('#password_repeat_register').val()) {
                    $('.step1').fadeOut('slow');
                    $('.step2').fadeIn('slow');
                }else{
                    $('.error1').html('passwords are not the same lol');
                }
            }else{
                $('.error1').html('please consider a valid email adress lol');
            }
        })
    </script>
</body>
</html>