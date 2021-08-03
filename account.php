<?
session_start();
$title = "Личный кабинет";
include "header.php";

echo "Привет, ".$_SESSION['user']['name']."<br>";
if( $_SESSION['user']['network'] != "" ){
    echo "Синхронизация с соц. сетью :".$_SESSION['user']['network'];
} else {
    echo '<div class="mb-3">
          <div id="uLogin_sync" data-ulogin="display=panel;theme=classic;fields=first_name,last_name;providers=google,vkontakte,mailru,facebook;hidden=;redirect_uri=http%3A%2F%2Fg99999ep.beget.tech%2Fphp-intern%2Fhandlers/network_sync.php;mobilebuttons=0;">
          </div>';
}

include "footer.php";
?>