<?php include 'api.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Amit Bhola">
		<title>Amit Bhola</title>
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/bootstrap-tagsinput.css" rel="stylesheet" media="screen">
		<link href="../css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link rel='stylesheet' href='../css/normalize.css' type='text/css'>
		
		<script type='text/javascript' src='../js/jquery.js'></script>
		<script src="../js/bootstrap.min.js" type="text/javascript"></script>  
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
	</head>
	
	<body>
		
		<?php include '../navbar.php' ?>
	
		<div class="container">
			
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<form enctype="multipart/form-data" class="add_edit_item" action="api.php?action=add_item" method="post">
						<div class="thumbnail">
							<div class="row">
								<div class="col-md-4">
									
									<center style="margin-bottom: 10px;">
										<i class="fa fa-upload" onclick="$('#attachment').trigger('click');" style="cursor:pointer; font-size: 5em;"></i>
										<input data-validation="required" 
												type="file" 
												name="attachment" style="display:none" id="attachment" />
									</center>
									<div class="caption"> 		
										<p>
											<input data-validation="required" placeholder="Title" name="title" class="form-control">
										</p>
										
									</div>
								</div> 
								<div class="col-md-5 ">
									<div class="caption">
										<p>
											<textarea rows="5" placeholder="Description" data-validation="required" name="description" class="form-control"></textarea>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="caption" >
										<div style="overflow:auto;max-height:114px;height:114px;">
											<?php 
											$selected_tags = [];
											include 'tags_input.php'; ?>
										</div> 
										
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="caption"> 
										<button type="submit" class="btn btn-primary">+ New</button>
									</div>
								</div>
							</div>
						</div> 
						
					</form>
				</div>
			</div>
			
			<div class="row"> 
				<?php include 'catalog.php'; ?> 
			</div>
			
			
		</div>
		
		<br><br><br>
		
		
		<script>
			
			$(document).ready(function(){
				$.validate({
					form: '.add_edit_item',
					modules : 'file',
					validateHiddenInputs: true
				});
			});
		</script>
		<!--[if lt IE 9]>
			<script src="js/ie.js"></script>
		<![endif]-->
	</body>
</html>