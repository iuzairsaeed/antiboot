<?php
error_reporting(0);
require_once("config.php");
require_once("init.php");

//Update the server response time
$servermng->updateResponse($odb);

echo '404 Error';
?>
