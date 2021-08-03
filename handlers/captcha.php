<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?
include "../db.php";
$guestIp = $_SERVER['REMOTE_ADDR'];
$ip_check_sql = "SELECT * FROM php_intern_guest WHERE ip = '$guestIp'";
$ip_check_result = $data_base->query( $ip_check_sql );
$guest = $ip_check_result->fetch_assoc();
if( $guest['auth_count'] >= 2 ){
 echo '<div class="g-recaptcha" data-sitekey="6LcbaM0bAAAAANI5Z2G4frEDPa_lLNvzscSxWo19"></div>';
}
?>