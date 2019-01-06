<?php include 'header.php'; ?>
<div class="row">
	<div class="col-md-4 col-sm-2 text-center hidden-sm hidden-xs"> 
		<img class="img-responsive pull-right" width="150" src="../img/japanese.jpg"> 
	</div>
	<div class="col-md-4 col-sm-12 text-center">
		<br><br>
		<button onclick="set_session('japanese','english');" class="btn btn-info">Japanese to English</button> 
	</div> 
	<div class="col-md-4 col-sm-2 text-center hidden-sm hidden-xs"> 
		<img class="img-responsive pull-left" style="height: 130px; width: auto;" src="../img/indian.jpg">
	</div> 
</div> 

<div class="row">
	<div class="col-md-4 col-sm-2 text-center hidden-sm hidden-xs"> 
		<img class="img-responsive pull-right" style="height: 130px; width: auto;" src="../img/indian.jpg">
	</div>
	<div class="col-md-4 col-sm-12 text-center">
		<br><br>
		<button onclick="set_session('english','japanese');" class="btn btn-success">English to Japanese</button> 
	</div> 
	<div class="col-md-4 col-sm-2 text-center hidden-sm hidden-xs"> 
		<img class="img-responsive pull-left" width="150" src="../img/japanese.jpg"> 
	</div> 
</div>
<div class="row">
	<?php 
	if(isset($_SESSION['from_language']) && isset($_SESSION['to_language']) && isset($_SESSION['word_series'])){
		?>
		<br><br>
		<div class="text-center col-md-10 col-md-offset-1">
			<a href="./vocabula.php">Resume existing session...</a>
		</div> 
		<br><br>
		<div class="text-center col-md-10 col-md-offset-1">
			<a href="./comfirm_clear_out.php" style="color:red;">Clear out existing session!</a>
		</div> 
		<?php
	}
	?>
	<div class="text-center col-md-10 col-md-offset-1" id="home-msg"> </div>
</div>
<?php include 'footer.php'; ?>