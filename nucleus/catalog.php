<?php
foreach(get_products() as $product){
	?>
	<div class="col-sm-6 col-md-6">
		<div class="thumbnail">
			<center>
				<i onclick="document.location.href='../store/files/<?= $product['file_name'] ?>'" class="fa fa-download" style="cursor:pointer; font-size: 5em;"></i>
			</center>
			<h3><?= $product['title'] ?></h3>
			<div class="caption">
				<p><?= $product['description'] ?></p>
				<p>
				<?php
				foreach($product['tags'] as $tag){
					?>
					<span style="cursor:pointer;" class="label label-info"><?= $tag['name'] ?></span>
					<?php
				} ?>
				<span style="cursor:pointer;" onclick="del_item(<?= $product['id'] ?>)" class="label label-danger">Delete</span>
				</p>
			</div>
		</div>
	</div>
	<?php
}
?>
<script>
	function del_item(id){
		$.post(
			'api.php?action=del_item',
			{id:id},
			function(data){
				if(parseInt(data) == 1){
					location.reload();
				}
				else{
					alert("Something went wrong!");
				}
			}
		);
	}
</script>

