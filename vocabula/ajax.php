<?php session_start() ?>
<?php include 'api.php' ?>
<?php 
if(isset($_GET['action'])){
	$function = $_GET['action'];
	print_r($function());
}
?>