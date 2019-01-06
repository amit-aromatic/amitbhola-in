<style>
body{ font-family:Nunito; }
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90664488-1', 'auto');
  ga('send', 'pageview');
</script>
<nav id="websitetop" class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="http://www.amitbhola.in">Amit Bhola</a>
			
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false" aria-controls="main-menu">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
		</div>
		
		<div class="collapse navbar-collapse" id="main-menu">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="http://www.amitbhola.in">Home</a></li> 
				<li><a href="http://www.amitbhola.in/vocabula">Vocabula <sup>beta</sup></a></li>
				<?php 
				if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in']==1)){
					?>
					<li><a href="http://www.amitbhola.in/nucleus/logout.php">Logout</a></li>
					<?php
				} ?>
			</ul>
		</div>
	</div>
</nav>