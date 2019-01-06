<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'admin';
$pass = 'admin';
$base = 'amitbhola';

// $host = 'localhost';
// $user = 'amit_bholaU';
// $pass = 'amit_bholaPwD3$';
// $base = 'amit_bhola';

// $mail_user = 'rahulbhola.softprodigy@gmail.com';
// $mail_pass = 'Softprodigy@123';
// $mail_host = 'smtp.gmail.com';

$mail_user = 'noreply@amitbhola.in';
$mail_pass = 'n0r3p1984';
$mail_host = 'sg2plcpnl0049.prod.sin2.secureserver.net';

try {
    $con = new PDO("mysql:host={$host};dbname={$base};charset=utf8", "{$user}", "{$pass}");
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
