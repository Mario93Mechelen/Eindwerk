<template>
    <div class="login_page">
        <img class="main_logo" alt="Semestr logo" src="img/Semestr_logo1_whitetext.png}">

        <div class="login-page-center">

            <form class="login-form">
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

            <div class="fb-login-intro"><span>or login with</span></div>
            <a class="btn btn-primary social_login facebook_login" href="/login/facebook">facebook</a>

        </div>
    </div>
</template>
<script>
    module.exports={

    }
</script>