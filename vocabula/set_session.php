<?php include 'ajax.php' ?>
<?php
$valid_languages = ['english','japanese'];
if(isset($_POST['from']) && isset($_POST['to']) && $_POST['from']!=$_POST['to'] && in_array($_POST['from'],$valid_languages) && in_array($_POST['to'],$valid_languages)){
	$_SESSION['from_language'] 	= $_POST['from'];
	$_SESSION['to_language'] 	= $_POST['to'];
	$word_series 				= json_decode(set_word_series(),true);
	if(is_array($word_series)){
		echo 1;
	}
	else{
		echo 0;
	}
}
else{
	echo 0;
}
?>