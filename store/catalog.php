<?php
$products = get_products();
if(count($products)){
	foreach($products as $pkey=>$product){
		if($pkey%2 == 0){
			//echo '<div style="clear:both;"></div>';
		}
		
		$tagStr = ''; 
		$tagCls = 'filter_tag_0'; 
		foreach($product['tags'] as $tag){
			$tagStr .= '<span onclick="apply_filter('.$tag['id'].')" class="store_tag label label-info">'.$tag['name'].'</span> ';
			$tagCls .= ' filter_tag_'.$tag['id'];
		}
		
		?>
		<div class="<?= $tagCls ?> store-item col-sm-12 col-xs-12 col-md-6">
			
				<h3 class="store-h3"><?= $product['title'] ?></h3>
			
				<div class="col-md-2 ">
					<a style="color:black !important;" href="javascript:download_file('<?= $product['file_name'] ?>')" target="_blank">
						<i class="fa fa-download" style="cursor:pointer; font-size: 3em;"></i>
					</a>
				</div>
				
				<div class="col-md-10 ">
					<p style="min-height:60px;">
						<?php 
						if(strlen($product['description']) > 115) {
							echo '<span class="toggledesc-'.$product['id'].'">';
								echo nl2br(substr($product['description'],0,115));
								echo '...';
								?>
								<a href="javascript:void(0)" onclick="$('.toggledesc-<?= $product['id'] ?>').toggle()">
									Read more
								</a>
								<?php
							echo '</span>';
							
							echo '<span style="display:none" class="toggledesc-'.$product['id'].'">';
								echo nl2br($product['description']); 
								?>
								<a href="javascript:void(0)" onclick="$('.toggledesc-<?= $product['id'] ?>').toggle()">
									Read less
								</a> 
								<?php
							echo '</span>';
						}
						else{
							echo $product['description'];
						}
						?>
					</p>
					
				</div>
				
				<p style="clear:both:margin:0px;min-height:45px;">
					<?= $tagStr ?> 
				</p>
			
		</div>
		<?php
	}
}
else{
	echo "<h2 style='margin:0 auto;text-align:center;color: #666;width:60%;'>We are building up amazing stuff for this section! Keep an eye on us! </h2>";
}
?> 
<script>
function download_file(file_name){
	
	if(typeof ga != 'undefined'){
		// ga('send', 'event', [eventCategory], [eventAction], [eventLabel], [eventValue], [fieldsObject]);
		ga('send', 'event', 'click', 'download', file_name, 1);
	}
	
	setTimeout(function(){
		var win = window.open('./store/files/'+file_name, '_blank');
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
			//Browser has blocked it
			alert('Please allow popups for this website');
		}
	},1000);
	
}
</script>



