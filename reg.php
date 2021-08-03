<?
session_start();
$title = "Регистрация";
include "header.php";
?>

<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <form class="reg_form">
                <div class="mb-3">
                    <label for="InputName">Введите имя:</label>
                    <input type="text" name="name" class="form-control name" id="InputName" required>
                    <div id="nameErrors" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="InputEmail">Введите email:</label>
                    <input type="email" name="email" class="form-control email email_reg" id="InputEmail" required>
                    <div id="emailErrors" class="form-text"></div>
                    <div id="emailCheck" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="InputPassword">Введите пароль:</label>
                    <input type="password" name="password" class="form-control password" id="InputPassword" required>
                    <div id="passwordErrors" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="InputPassword_second">Повторите пароль:</label>
                    <input type="password" name="password_second" class="form-control password_second" id="InputPassword_second" required>
                    <div id="passwordSecondErrors" class="form-text"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-reg">Зарегистрироваться</button>
            </form>
            <div class="alerts"></div>
        </div>
        <div class="col"></div>
    </div>
</div>
      
<?
include "footer.php";
?>