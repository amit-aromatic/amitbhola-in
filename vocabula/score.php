<?php include 'header.php'; ?>
<?php 
if(!isset($_SESSION['from_language']) || !isset($_SESSION['to_language']) || !isset($_SESSION['word_series'])){
	header('location:index.php');
}
$from_language = $_SESSION['from_language'];
$to_language   = $_SESSION['to_language'];
$_SESSION['word_series']['score'] = count(array_filter($_SESSION['word_series']['covered'])) - count($_SESSION['word_series']['forgot']);
?>
<div class="row score">
	
	<div class="text-center col-md-10 col-md-offset-1">
		<div class="alert alert-info"> Your score is:  <b><?= $_SESSION['word_series']['score'] ?> / <?= count(array_filter($_SESSION['word_series']['covered'])) ?></b> </div>
		<br>
		<a class="btn btn-success" href="./start_over.php">Start Over</a> 
		<a class="btn btn-info" href="javascript:void(0)" onclick="take_action('display_all')">Display All</a> 
		<a class="btn btn-info" href="javascript:void(0)" onclick="take_action('email_all')">Email All</a> 
		<?php 
		if(count($_SESSION['word_series']['forgot'])){ ?>
			<a class="btn btn-danger" href="./run_forgot.php">Replay Forgot ones</a> 
			<a class="btn btn-danger" href="javascript:void(0)" onclick="take_action('display_forgotten')">Display Forgot ones</a> 
			<a class="btn btn-danger" href="javascript:void(0)" onclick="take_action('email_forgotten')">Email Forgot ones</a> 
			<?php
		} ?> 
	</div>
	
	<div id="option_output" class="text-center col-md-10 col-md-offset-1"></div>
	
</div>
<?php include 'footer.php'; ?>