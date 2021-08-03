<?
session_start();

include "../db.php";

$guest_ip = $_SERVER['REMOTE_ADDR'];
$ip_db_delete = "DELETE FROM php_intern_guest WHERE ip='$guest_ip'"; // запрос для удаления строки гостя
$captcha_flag = 0; // флаг пройдена капча или нет
$login_count; // переменная для записи количества попыток входа для показа капчи если их больше 3
$user_email; // для передачи значения email пользователя при авторизации через соц сеть


$ip_check_sql = "SELECT * FROM php_intern_guest WHERE ip='$guest_ip'"; // поиск в базе guest по ip данных о количестве попыток входа
$ip_check_result = $data_base->query( $ip_check_sql );
if( $ip_check_result->num_rows == 0 ){ // если нет совпадений создаётся новая запись и количество попыток становится 1, так как это первая попытка авторизации с данного ip
    $ip_new_sql = "INSERT INTO php_intern_guest ( ip, auth_count ) VALUES ( '$guest_ip', 1 )"; 
    $ip_new_result = $data_base->query( $ip_new_sql );
    $login_count = 1;
} else { // + 1 попытка авторизации
    $guest = $ip_check_result->fetch_assoc();
    $new_auth_count = $guest['auth_count'] + 1;
    $auth_count_update_sql = "UPDATE php_intern_guest SET auth_count=$new_auth_count WHERE ip='$guest_ip'";
    $data_base->query( $auth_count_update_sql );
    $login_count = $new_auth_count;
}


$captcha = $_POST['g-recaptcha-response'];
$key = '6LcbaM0bAAAAAPvkVJ1agMLofttTb3okGZPZ0DXe';
if ( $login_count > 3 and isset( $_POST['email'] ) ){ // если попыток входа больше 3 и авторизация была через форму происходит проверка капчи 
    if ( isset( $captcha ) ){
        $api_request_options = array( // установка метода POST для капчи
            'http'=>array(
                'method'=>"GET",
            )
        );
        $api_request_context = stream_context_create( $opts );
    
        $api_result = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$captcha."&remoteip=".$guest_ip, false, $api_request_context );
        $captcha_result = json_decode( $api_result, true );
        if( $captcha_result['success'] ) {
            $captcha_flag = 1;
        } else {
            exit ( "<br><div class='alert alert-danger' role='alert'>Captcha не пройдена</div>" );
        }
    } else {
        exit ( "<br><div class='alert alert-warning' role='alert'>Пройдите captcha</div>" );
    }
}

if ( isset( $_POST['email'] ) and ( $captcha_flag = 1 or $login_count <= 3 ) ){ // если авторизация происходит через форму и капча верна или пока что не требуется
    $auth_email = md5( htmlspecialchars( $_POST['email'] ) );
    $auth_password = md5( htmlspecialchars( $_POST['password'] ) );
    if ( strlen( $auth_password ) < 6 ){ // проверка на правильную длину пароля
        exit ( "<br><div class='alert alert-warning' role='alert'>Минимальная длина пароля 6 символов</div>" );
    }
    $prepared_auth = $data_base->prepare( "SELECT * FROM php_intern_user WHERE email=? and password=?" );
    $prepared_auth->bind_param( "ss", $auth_email, $auth_password );
    $prepared_auth->execute();
    $auth_result = $prepared_auth->get_result();
    $user = $auth_result->fetch_assoc();
    $user_email = $user['email'];
    if($auth_result->num_rows == 0){
        exit ( "<br><div class='alert alert-danger' role='alert'>Неверная почта или пароль</div>" );
    } else {
        $_SESSION['user'] = $user;
        $data_base->query( $ip_db_delete ); // удаление записи о попытках входа
        exit ( "<br><div class='alert alert-success' role='alert'>Авторизация прошла успешно</div>" );
    }
} else { // если авторизация была с помощью uLOGIN
    
    $s = file_get_contents( 'http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST'] );
    $network = json_decode( $s, true );
    
    $user_name = $network['first_name'];
    $user_network = $network['network'];
    $user_uid = md5( $network['uid'] );
    
    $prepared_network = $data_base->prepare( "SELECT * FROM php_intern_user WHERE uid=?" ); // проверка привязана ли уже данная соц сеть к какому нибудь аккаунту 
    $prepared_network->bind_param( "s", $user_uid );
    $prepared_network->execute();
    $network_result = $prepared_network->get_result();
    $check_network_email = $network_result->fetch_assoc();
    
    if( $network_result->num_rows == 0 and $network['verified_email'] == 1 ){ // если не привязана и если почта подтверждена
        
        $prepared_network_reg = $data_base->prepare( "INSERT INTO php_intern_user ( name, email, network, uid ) VALUES ( ?, ?, ?, ? )" ); // создание учётной записи с данными из соц сети
        $prepared_network_reg->bind_param( "ssss", $user_name, $user_email, $user_network, $user_uid );
        $network_reg_result = $prepared_network_reg->execute();
        $_SESSION['user'] = [
            "name"=>"$user_name",
            "email"=>"$user_email",
            "network"=>"$user_network",
            ];
        if( $network_reg_result == true ){ // если запись создана успешно то удаляется запись гостя в БД и выполняется переадресация
            $data_base->query( $ip_db_delete );
            header( 'Location: ../account.php' );
            
        }
    } else { // если данная соц сеть привязана к аккаунту ->
        if( $check_network_email['uid'] == $user_uid and $network['verified_email'] == 1 ){ // если найдена похожая запись c uid и подтверждена почта
            $_SESSION['user'] = [
                "name"=>"$user_name",
                "email"=>"$user_email",
                "network"=>"$user_network",
            ];
            $data_base->query( $ip_db_delete );
            header( 'Location: ../account.php' );
        } else {
            exit ( "<h2 style='color:red;'>Ошибка авторизации через соц. сеть</h2>" );
        }
        
    }
}
                