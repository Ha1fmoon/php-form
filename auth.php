<?
session_start();

$title = "Авторизация";

include "header.php";
include "db.php";
?>

<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <form class="auth_form" >
                <div class="mb-3">
                    <label for="InputEmail">Введите email:</label>
                    <input type="email" name="email" class="form-control email" id="InputEmail" required>
                    <div id="emailErrors" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="InputPassword">Введите пароль:</label>
                    <input type="password" name="password" class="form-control password" id="InputPassword" autocomplete="current-password" required>
                    <div id="passwordErrors" class="form-text"></div>
                </div>
                <div class="captcha-placeholder"></div>
                <button type="submit" class="btn btn-primary btn-auth">Войти</button> 
                <div class="mb-3">
                    <p>Или авторизуйтесь с помощью соц.сети</p>
                    <div id="uLogin" data-ulogin="display=panel;theme=classic;fields=first_name,last_name;providers=google,vkontakte,mailru,facebook;hidden=;redirect_uri=http%3A%2F%2Fg99999ep.beget.tech%2Fphp-intern%2Fhandlers/auth_handler.php;mobilebuttons=0;"></div>
                </div>
            </form>
            <div class="alerts"></div>
        </div>
        <div class="col"></div>
    </div>
</div>
   
<?
include "footer.php";
?>