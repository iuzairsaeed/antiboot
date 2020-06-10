<?php
$test_mode = 0;//Only change to 1 on test server.

//This function get the url adress to put it in js and css links.
$my_site_url = '//'.$_SERVER['SERVER_NAME'].'';// If do you want to put this code in a folder, instead root folder, put the folder like this '//'.$_SERVER['SERVER_NAME'].'/folder_name'
$my_site_name = 'OrionStress';// Put your Website name Here.

//credentials recaptcha
$site_key = '6Leo_fYUAAAAAL3qZDISQzXQnCnyQN30kE_66yJ3';// server antiboot '6LdeVvkUAAAAANyENw0LJgJRhFiShirPDwpk1AXJ'; //Lz '6Le_XfcUAAAAAJG0QCsAr5yKTSGgl87Qx-joY6qo'; //Localhost 
$secret_key =  'GnMsKgMwNN0DvNwH_3'; //server antiboot '6LdeVvkUAAAAAFqrYZiVuNXNwwf_MP1c5mw5f4SV'; //Lz '6Le_XfcUAAAAAC84zaNJeoo0HQ0O0KM3w2mJsZLw'; //localhost 

//Block pages from website
$pages_to_exclude = array('skyperesolver.php','domainresolver.php');//put any page do you whant to remove here;

//Default package of every user
$free_package = 1;// 0 - to disable free package
$days_to_expire = 365;// Days to expiration the free package.

if($test_mode == 0){
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	//Change your BD connection credentials here
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'antiboot3_boot');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	
}else{
	ini_set('display_startup_errors',0);
	ini_set('display_errors',0);
	error_reporting(0);
	//Dont change it... Its for DB test
	define('DB_HOST', 'localhost');	define('DB_NAME', 'antiboot3_boot'); define('DB_USERNAME', 'root'); define('DB_PASSWORD', '');	
}



$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
putenv("TZ=America/Chicago");

$encKey = "_321KLX12le1x2mMxm1?!"; //Put your unique encryption key here

//Encryption
function encryptData($value, $key){ 
   $text = $value; 
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB); 
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
   $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv); 
   return base64_encode($crypttext); 
} 

function decryptData($value, $key){ 
   $crypttext = base64_decode($value); 
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB); 
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
   $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv); 
   return trim($decrypttext); 
}

if($free_package==1){ 
	$package_default = 1;//id of package 
   $maxboot_default = 120; 
   $date_to_expire = strtotime('+'.$days_to_expire.' days');
}


?>