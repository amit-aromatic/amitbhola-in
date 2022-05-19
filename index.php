<?php //session_start(); ?>
<?php include 'store/api.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Production Engineer from Punjab Engineering College, Chandigarh, India.">
		<meta name="keywords" content="amit, engineer">
		<meta name="author" content="Amit Bhola">
		<title>Amit Bhola</title>
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<link rel='stylesheet' href='css/normalize.css' type='text/css'>


		<script type='text/javascript' src='js/jquery.js'></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
	</head>

	<body >

		<?php include './navbar.php' ?>

		<div class="container">

			<div class="row">
				<div class="col-md-2 text-center">
					<img class="img-responsive img-rounded" src="img/Major_Tom2.jpg" style="width:200px" alt="Amit Bhola" />
				</div>
				<div class="col-md-10" >
					<h3 style="margin-top: 0px;">
						Amit Bhola
					</h3>
					<p>
						A graduate from Punjab Engineering College Chandigarh class of 2007, Amit has attempted to remain a student ever since. Much of it was made possible by the practically infinite sum of knowledge available freely over internet. This website, a suggestion and work from his brother <a href="http://rahulbhola.com">Rahul</a> is a small step towards sharing of tiny bits of knowledge and ideas for others to build on. The page includes source codes of the software items. The content is in form of pdf or zip files.
					</p>
					<p>
						An old page which he has given up editing, and which gave him a good pen friend can be visited <a href="https://sites.google.com/site/amitaromatic/amitbhola">here</a>.
					</p>
					<p>
						He works as an <a href="https://www.linkedin.com/in/amit-bhola-208b981a/" target="_blank">R&D professional</a> and lives in Gurgaon, India. He can be contacted by email at <i>amit_aromatic@yahoo.com</i>
					</p>

				</div>
			</div>

			<div class="row">
				<hr>
				<div class="col-md-12" style="margin-top: -40px;">
					<span class="btn btn-success" style="margin:5px auto;width:100px;display: block;">Tools</span>
				</div>

				<div class="col-md-12" >
					<h3>Vocabula</h3>
					<p>
						Vocabula, is a simple quiz to test your japanese vocabulary. <a href="/vocabula">Try Now</a>
					</p>
				</div>

			</div>

			<div class="row" id="store">
				<hr>
				<div class="col-md-12" style="margin-top: -40px;">
					<span class="btn btn-success" style="margin:5px auto;width:100px;display: block;">Store</span>
					<p>
						<a target="_blank" href="https://github.com/amit-aromatic/">View on Github</a>
						<br>
						Filter a category from dropdown or by clicking a category tag in the items.
					</p>
				</div>

				<div class="col-md-12">
					<br>
					<?php include 'store/filters.php'; ?>
				</div>
				<div class="col-md-12">
					<br>
					<?php include 'store/catalog.php'; ?>
				</div>
			</div>

		</div>

		<div id="fixbtns">
			<a id="removefilters" href="javascript:void(0)" class="btn btn-primary" onclick="apply_filter(0);">
				"<span id="filter_name"></span>"
				Remove Filter
			</a>
			<div style="clear:both"></div><br>
			<a id="scrolltostore" href="javascript:void(0)"  onclick="goToByScroll('websitetop');">Scroll Up</a>
		</div>

		<br><br><br>

		<script>
			$(window).scroll(function(){
				if ($(window).scrollTop() > $('#store').offset().top){
					console.log('show');
					$('#scrolltostore').show();
				}
				else{
					console.log('hide');
					$('#scrolltostore').hide();
				}
			});
			function goToByScroll(id){
				  // Remove "link" from the ID
				id = id.replace("link", "");
				  // Scroll
				$('html,body').animate({
					scrollTop: $("#"+id).offset().top},
					'slow');
			}
		</script>

		<!--[if lt IE 9]>
			<script src="js/ie.js"></script>
		<![endif]-->
	</body>
</html>
