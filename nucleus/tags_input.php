<span id="select_tags_span" style="display:block">
	<?php
	foreach(get_tags() as $tag){
		$checked = in_array($tag['id'],$selected_tags) ? "checked" : "";
		?>
		<span style="display:block">
			<input <?= $checked ?> type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" /> <?= $tag['name'] ?>
		</span>
		<?php
	}
	?>
	<span style="display:inline-block">
		<input type="checkbox" name="tags[]" value="" class="tagval"/> <input onkeyup="$(this).siblings('.tagval').val($(this).val());" type="text" class="new_tag" />
	</span>
	<template name="new_tag" style="display:none">
		<span style="display:inline-block">
			<input type="checkbox" name="tags[]" value="" class="tagval"/> <input onkeyup="$(this).siblings('.tagval').val($(this).val());" type="text" class="new_tag" />
		</span>
	</template>
</span>
<a href="javascript:void(0)" onclick="add_another_tag()">add more...</a>

<script>

function add_another_tag(){
	$('#select_tags_span').append($('template[name="new_tag"]').html());
}

$('input.new_tag').on('keyup',function(e){
	
});
</script>
