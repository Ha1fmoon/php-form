<?
session_start();

include "../db.php";
$sync_email = $_SESSION['user']['email'];
$sync_check_sql = "SELECT * FROM php_intern_user WHERE email='$sync_email'";
$sync_check_result = $data_base->query( $sync_check_sql );
$sync_check_result = $sync_check_result->fetch_assoc();
 if( $sync_check_result['network'] == "" ){ // если в сессии нет данных о сети и uid пользователя
    $s = file_get_contents( 'http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST'] );
    $network = json_decode( $s, true );
       
    $user_name = $network['first_name'];
    $user_email = md5( $network['email'] );
    $user_network = $network['network'];
    $user_uid = md5( $network['uid'] );
    
    $network_check_sql = "SELECT * FROM php_intern_user WHERE uid='$user_uid'";
    $network_check_result = $data_base->query( $network_check_sql );
    if( $network_check_result->num_rows == 0 and $network['verified_email'] == 1 ){
        $sync_set_sql = "UPDATE php_intern_user SET uid='$user_uid', network='$user_network', name='$user_name' WHERE email='$sync_email'";
        $network_set_result = $data_base->query( $sync_set_sql );
        if ( $network_set_result ){
            $_SESSION['user']['network'] = $user_network;
            header( 'Location: ../account.php' );
        } else {
            exit ( "Ошибка синхронизации" );
        }
    } else {
    exit ( "Данная соц сеть уже привязана к другому аккаунту" );
    }
} else {
    exit ( "К данному аккаунту уже привязана соц. сеть" );
}
