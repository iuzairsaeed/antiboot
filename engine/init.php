<?php
error_reporting(0);
define('DIRECT', TRUE);
$cloudflare = 1; // 1 = Cloudflare is On , 2 = Cloudflare is Off
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	elseif ($_SERVER["HTTP_CF_CONNECTING_IP"]) {
		$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
$_SERVER['REMOTE_ADDR'] = getRealIpAddr();
require 'functions.php';
require 'SSH2.php';
$user = new user;
$stats = new stats;
$servermng = new server;
$apimng = new apiattack;
$gsettings = new settings;
$web_title = $gsettings -> getSiteTitle($odb).' - ';

//Used for BTC Callback
$blockchain_root = 'https://blockchain.info/'; 
$mysite_root = 'http://'.$gsettings -> getSiteUrl($odb).'/';
$secret = 'SSMemvieOa9d1lacmie301imfASDi'; // Change this only once
$my_bitcoin_address = $gsettings -> getBTCAddress($odb);

$currentpage = $_SERVER['SCRIPT_NAME'];
function CheckPageA($page)
{
	global $currentpage;
	if (strstr($currentpage, $page))
	{
		echo ' active';
	}
}
function CheckPageB($page)
{
	global $currentpage;
	if (strstr($currentpage, $page))
	{
		echo ' opened active expanded has-sub';
	}
}

if(!in_array('curl', get_loaded_extensions()))
{
    die("Please install the Curl Library.");
}

if(!function_exists('fsockopen'))
{
    die('Please enable fsockopen() in your php.ini file!');
}

foreach($pages_to_exclude as $r_page){
		if (strstr($currentpage, $r_page)){
			header('location: index.php');
			die();
		}
	}
?>