<?php
session_start();
$redirect = 'index.php';
$_SESSION['logged_in'] = 0;
header("location:$redirect");
?>