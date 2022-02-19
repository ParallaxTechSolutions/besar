<?php
//$conn = mysqli_connect('localhost', 'mooncake_tbmuser', 'mooncake_tbmpass', 'mooncake_shop_laravel');
//$conn = mysqli_connect('localhost', 'w821ritz_ritzgar', 'fQT8;$iD;D;!', 'w821ritz_ritzgardenhotel');
$conn = mysqli_connect('localhost', 'besar7', 'ju9a6amaq', 'webqom_besar7');

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'globalDiscounts'){
	$sql = "UPDATE promocodes SET status = '0' WHERE end_date < '" . date('Y-m-d') . "'";
	mysqli_query($conn, $sql);
}

