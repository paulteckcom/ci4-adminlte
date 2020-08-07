<?php 
require_once('vendor/autoload.php');
$pair  = $_REQUEST['pair'];

$exchange = new \ccxt\binance([
	'verbose' => false
]);

try {
    $ticker = $exchange->fetch_ticker($pair);


	$last = number_format($ticker['last'], 8);
	

	echo preg_replace("/\.?0+$/", "", $last);

}catch (\ccxt\NetworkError $e) {
    echo '';
} catch (\ccxt\ExchangeError $e) {
    echo '';
} catch (Exception $e) {
    echo '';
}
?>