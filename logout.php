<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['ID']);
unset($_SESSION['wsource']);
unset($_SESSION['email']);
session_destroy();
header('location: login.php');
?>