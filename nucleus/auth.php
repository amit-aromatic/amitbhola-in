<?php
session_start();
$redirect = 'index.php';
//tima
//@m!$k3y
if(isset($_POST['uname']) && isset($_POST['pwd'])){
	if($_POST['uname']=='tima' && $_POST['pwd']=='@m!$k3y'){
		$_SESSION['logged_in'] = 1;
		$redirect = 'dashboard.php';
	}
}
header("location:$redirect");
?>
