<?php include 'header.php'; ?>
<?php 
if(!isset($_SESSION['from_language']) || !isset($_SESSION['to_language']) || !isset($_SESSION['word_series'])){
	header('location:index.php');
}
$from_language = $_SESSION['from_language'];
$to_language   = $_SESSION['to_language'];
?>
<div class="row">
	<div class="text-center col-md-10 col-md-offset-1">
		
		<div id="jswords"></div>
		
		<?php
		// print_session_series();
		$word_series 	= $_SESSION['word_series']; 
		if(count($word_series['covered']) < count($word_series['series'])){
			$word = json_decode(get_current_word_from_session(),true);
			if(is_array($word)){ 
				?> 
				<input type="hidden" id="this_current_word" value='<?= htmlentities(json_encode($word)); ?>' />
				
				<input type="hidden" id="start_current_word" value="<?= isset($_SESSION['word_series']['current']) ? $_SESSION['word_series']['current'] : 0 ?>" />
				
				<div class="row">
					<div class="col-md-6 col-md-offset-3 col-sm-12 text-center">
						What is the meaning of following <b><span id="from_language"><?= $word['from_language'] ?></span></b> word in <b><span id="from_language"><?= $word['to_language'] ?></span></b>?
						
						<br>
						<!-- a href="./score.php">Check score</a --> 
						<a href="javascript:void(0)" onclick="check_score();">Check score</a> 
						
						<h1 id="question_word">
							<?= $word[$word['from_language']] ?>
							<? $word['id'] ?>
						</h1>
						<br>
					</div>
				</div>
				
				<div class="row">
					<br>
					<button onclick="get_prev();" class="col-xs-2 col-xs-offset-3 btn btn-info">Prev</button> 
					<div class="col-xs-2"></div> 
					<button onclick="mark_covered();" class="col-xs-2 btn btn-success">Next</button> 				
				</div>
				
				<br>
				<div class="row"> 
					<button onclick="mark_forgot();" class="col-xs-6 col-xs-offset-3 btn btn-danger">Mark as forgot</button> 
				</div>
				
				<div class="row">
					<br>
					<div class="col-md-6 col-md-offset-3 col-sm-12 text-center">
						<a id="show_answer" href="javascript:void(0)" class="btn btn-default" onclick="$('#answer_word').toggle();">toggle meaning</a>
						<h1 id="answer_word" style="display:none;"><?= $word[$word['to_language']] ?></h1>
					</div>
				</div>
				<?php
			}
			else{
				?>
				<div class="alert alert-danger">Something went wrong!</div>
				<?php
			}
		}
		else{ 
			// print_session_series();
			header('location:score.php'); 
		}
		?>
	</div>
</div>
<?php include 'footer.php'; ?>