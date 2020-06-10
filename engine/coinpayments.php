<?php
error_reporting(0);
include 'config.php';
include 'init.php';

// Fill these in with the information from your CoinPayments.net account. 
$cp_merchant_id = $gsettings -> getMerchant($odb);
$cp_ipn_secret = $gsettings -> getIPNSecret($odb);
$cp_debug_email = ''; //enter an email which you want to receive logs or leave blank
 
//Which currency you want to accept
$order_currency = 'USD';
 
function errorAndDie($error_msg) { 
	global $cp_debug_email; 
	if (!empty($cp_debug_email)) { 
		$report = 'Error: '.$error_msg."\n\n"; 
		$report .= "POST Data\n\n"; 
		foreach ($_POST as $k => $v) { 
			$report .= "|$k| = |$v|\n"; 
		} 
		mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
	} 
	die('IPN Error: '.$error_msg); 
} 
 
if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
	errorAndDie('IPN Mode is not HMAC'); 
} 
 
if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
	errorAndDie('No HMAC signature sent.'); 
} 
 
$request = file_get_contents('php://input'); 
if ($request === FALSE || empty($request)) { 
	errorAndDie('Error reading POST data'); 
} 
 
if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
	errorAndDie('No or incorrect Merchant ID passed'); 
} 
	 
$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
if ($hmac != $_SERVER['HTTP_HMAC']) { 
	errorAndDie('HMAC signature does not match'); 
} 
 
// HMAC Signature verified at this point, load some variables. 

$txn_id = $_POST['txn_id']; //Needed to log
$item_name = $_POST['item_name'];  //Not really needed but let's get this
$item_number = $_POST['item_number'];  //We are going to check this and give the membership.
$custom = $_POST['custom']; //Here we will have the user and package id
$amount1 = floatval($_POST['amount1']); // The total amount of the payment in your original currency/coin.
$amount2 = floatval($_POST['amount2']); // The total amount of the payment in the buyer's selected coin.
$currency1 = $_POST['currency1']; // The original currency/coin submitted in your button.
$currency2 = $_POST['currency2']; // The coin the buyer chose to pay with.
$status = intval($_POST['status']); // The status of the payment.
$status_text = $_POST['status_text']; //A text string describing the status of the payment.


// Check the original currency to make sure the buyer didn't change it. 
if ($currency1 != $order_currency) { 
	errorAndDie('Original currency mismatch!'); 
}     

//Get Package ID and User ID
list($membership_id, $user_id) = explode("_", $custom);

//Get Package Price
$pricesql = $odb -> prepare("SELECT `price` FROM `packages` WHERE id = :id");
$pricesql -> execute(array(":id" => (int)$membership_id));
$price = $pricesql -> fetchColumn(0);
// Check amount against order total 
if ($amount1 < $price) { 
	errorAndDie('Amount is less than order total!'); 
}


if ($status >= 100 || $status == 2) {
	$data = array(
		':tid' => $txn_id, 
		':plan' => (int)$membership_id,
		':user' => (int)$user_id,
		':status' => $status,
		':paid' => $amount1, 
	  );
	  $odb -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	  $insertsql = $odb -> prepare("INSERT INTO `btc_payments` VALUES(NULL, :paid, :plan, :user, :tid, :status, UNIX_TIMESTAMP())");
	  $insertsql -> execute($data);
						
//GET PACKAGE DETAILS
$SQLGetPackages = $odb -> prepare("SELECT * FROM `packages` WHERE `id` = :id LIMIT 1");
$SQLGetPackages -> execute(array(':id' => $membership_id));
$getInfo = $SQLGetPackages -> fetch(PDO::FETCH_ASSOC);
$maxboot = $getInfo['mbt'];
//$concurrents = $packageInfo['concurrents'];
$plength = $getInfo['length'];
$unit = $getInfo['unit'];
$newExpire = strtotime(date('Y/m/d')."+{$plength} {$unit}");

$update1 = $odb -> prepare("UPDATE `users` SET `expire` = :expire WHERE `ID` = :id");
$update1 -> execute(array(':expire' => $newExpire, ':id' => $user_id));
$update2 = $odb -> prepare("UPDATE `users` SET `package` = :plan WHERE `ID` = :id");
$update2 -> execute(array(':plan' => $membership_id, ':id' => $user_id));
$update3 = $odb -> prepare("UPDATE `users` SET `maxboot` = :mbt WHERE `ID` = :id");
$update3 -> execute(array(':mbt' => $maxboot, ':id' => $user_id));

} else if ($status < 0) { 
	echo $status_text;
} else { 
	echo $status_text;
} 
die('IPN OK');
	
?>