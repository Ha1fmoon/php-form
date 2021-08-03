<?
include "../db.php";

$check_email = md5( htmlspecialchars( $_POST['email'] ) );

$prepared_email_check = $data_base->prepare( "SELECT * FROM php_intern_user WHERE email=?" );
$prepared_email_check->bind_param( "s", $check_email );
$prepared_email_check->execute();
$email_check_result = $prepared_email_check->get_result();
if( $email_check_result->num_rows == 0 ){
    exit ( "<span style='color: green'>&#10003;Почта свободна</span>" );
} else {
    exit ( "<span style='color: red'>&#10005;Почта занята</span>" );
}