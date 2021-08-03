<?
session_start();

include "../db.php";

$reg_email = md5( htmlspecialchars( $_POST['email'] ) );
$reg_password = md5( htmlspecialchars( $_POST['password'] ) );
$reg_password_second = md5( htmlspecialchars( $_POST['password_second'] ) );
$reg_name = $_POST['name'];

if ( strlen( $reg_name ) < 3 ){ // проверка на длину символов в имени - не меньше 3
    exit ( "<br><div class='alert alert-warning' role='alert'>Длина имени должна быть не менее 3-х символов</div>" );
}
if ( $reg_password != $reg_password_second ){ // проверка пароля
   exit ("<br><div class='alert alert-warning' role='alert'>Пароли не совпадают</div>");
}

$prepared_reg = $data_base->prepare( "INSERT INTO php_intern_user ( email, password, name ) VALUES ( ?, ?, ? )" );
$prepared_reg->bind_param( "sss", $reg_email, $reg_password, $reg_name );
$reg_result = $prepared_reg->execute();
if ( $reg_result ){
    $_SESSION['user'] = [
        "name"=>"$reg_name",
        "email"=>"$reg_email",
    ];
    exit ( "<br><div class='alert alert-success' role='alert'>Регистрация прошла успешно</div>" );
} else {
    exit ( "<br><div class='alert alert-danger' role='alert'>Пользователь с такой почтой уже существует</div>" );
}