<select id="fselect" style="margin-left: 10px; " onchange="apply_filter(this.value)">
	<?php
	$tags = get_tags();
	echo '<option value="0" id="btn-filter-0">
			All ( '.get_products_cnt().' ) 
		  </option> ';
	foreach($tags as $tag){
		echo '<option id="btn-filter-'.$tag['id'].'" value="'.$tag['id'].'">
				'.$tag['name'].' ( '.$tag['prod_cnt'].' ) 
			  </option> ';
	}
	?>
</select>
<script>
	function apply_filter(tag_id){
		
		$('#fselect').val(tag_id);
		
		$('.filter_tag_0').hide();
		$('.filter_tag_'+tag_id).show();
		
		if(tag_id!=0){
			$('#removefilters').show();
		}
		else{
			$('#removefilters').hide();
		}
		
		$('#filter_name').html($('#btn-filter-'+tag_id).text());
		
	}
	
</script> 