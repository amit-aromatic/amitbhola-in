var forgot  	= [];
var covered 	= [];  
var words   	= [];
var current 	= 0;

$(document).ready(function(){ 
	if($('#start_current_word').length > 0){
		current 		= $('#start_current_word').val();
		words[current] 	= (JSON.parse($('#this_current_word').val()));
	}
});

function set_session(from,to){
	$('#home-msg').html('Setting your session...');
	
	$.post(
		'set_session.php',
		{from:from,to:to},
		function(data){
			if(parseInt(data) == 1){
				document.location.href = 'vocabula.php';
			}
			else{
				$('#home-msg').html('Select valid option!');
				setTimeout(function(){ $('#home-msg').html(''); },5000);
			}
		}
	);
}

function refresh_meta_data(callback){
	$.post(
		'ajax.php?action=refresh_meta_data',
		{current:current,covered:JSON.stringify(covered),forgot:JSON.stringify(forgot)},
		function(data){
			callback();
		}
	); 
}

function mark_covered(){
	
	// $.post(
		// 'ajax.php?action=mark_covered_in_session',
		// function(data){
			// if(data != '0'){
				covered.push(parseInt(current));
				current++;
				if(typeof words[current] == 'object'){
					place_new_word_new(words[current]);
				}
				else{
					// get_next_words_from_session();
					refresh_meta_data(get_next_words_from_session);
				}
				
			// }
			// else{
				// alert('Something went wrong!');
			// }
		// }
	// ); 
}

function mark_forgot(){
	
	// $.post(
		// 'ajax.php?action=mark_forgot_in_session',
		// function(data){
			// if(data != '0'){
				
				forgot.push(parseInt(current));
				covered.push(parseInt(current));
				current++;
				if(typeof words[current] == 'object'){
					place_new_word_new(words[current]);
				}
				else{
					// get_next_words_from_session();
					refresh_meta_data(get_next_words_from_session);
				}
			
			// }
			// else{
				// alert('Something went wrong!');
			// }
		// }
	// ); 
}

function get_prev(){
	
	$.post(
		'ajax.php?action=get_prev_word_from_session',
		function(data){
			current--;
			if (current<0){
				get_prev_words_from_session();
			}
			else if(typeof words[current] == 'object'){
				place_new_word_new(words[current]);
			}
			else{
				// get_prev_words_from_session();
				refresh_meta_data(get_prev_words_from_session);
			}
		}
	); 
	
}

var get_prev_words_from_session = function(){

	var t = new Date;
	$.ajax({
		type: "POST",
		url: "ajax.php?action=get_prev_words_from_session&_="+t.toString(), 
		contentType: "application/json",
		dataType: 'json',
		success: function(data) {
			if(typeof data.finished !='undefined'){
				/* do nothing */
			}
			else{
				$.each(data,function(k,w){
					if ((current-k) >=0 )
						words[current-k] = (w);
				});
				
				if (current<0){
					current = 0
				}
				place_new_word_new(words[current]);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert('Something went wrong!');
		} 
	}); 
	
}

function check_score(){
	refresh_meta_data(function(){ document.location.href = './score.php'; });
}

var get_next_words_from_session = function(){
	var t = new Date;
	$.ajax({
		type: "POST",
		url: "ajax.php?action=get_next_words_from_session&_="+t.toString(), 
		contentType: "application/json",
		dataType: 'json',
		success: function(data) {
			if(data != '0'){
				
				if(typeof data.finished !='undefined'){
					// document.location.href = './score.php';
					check_score();
				}
				else{ 			
					$.each(data,function(k,w){
						words.push(w); 
					});
					place_new_word_new(words[current]);
				}
			}
			else{
				alert('Something went wrong!');
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert('Something went wrong!');
		} 
	});
	 
}

function place_new_word_new(data){
	// $('#jswords').html('');
	// $.each(words,function(k,v){
		// if(typeof v != 'undefined'){
			// $('#jswords').append(v.word[data.from_language]+',');
		// }
	// });
	$('#from_language').html(data.from_language);
	$('#to_language').html(data.to_language);
	$('#question_word').html(data.word[data.from_language] ); //+ data.word["id"]
	$('#answer_word').hide();
	$('#answer_word').html(data.word[data.to_language]);
}

function place_new_word(data){
	var word = JSON.parse(data);
	if(parseInt(word['finished']) == 0){
		$('#from_language').html(word['from_language']);
		$('#to_language').html(word['to_language']);
		$('#question_word').html(word[word['from_language']]);
		$('#answer_word').hide();
		$('#answer_word').html(word[word['to_language']]);
	}
	else{
		document.location.href = 'score.php';
	}
}

function take_action(action){
	$('#option_output').html('Loading...');
	$.post(
		'ajax.php?action='+action,
		function(data){
			if(data != '0'){
				$('#option_output').html(data);
			}
			else{
				alert('Something went wrong!');
			}
		}
	);
}

function send_forgotten(){
	$.post(
		'ajax.php?action=send_forgotten',
		{email:$('#email_forgotten').val()},
		function(data){
			if(data.trim() == '1'){
				alert('Mail Sent!');
			}
			else{
				alert('Something went wrong!');
			}
		}
	);
}

function send_all(){
	$.post(
		'ajax.php?action=send_all',
		{email:$('#email_all').val()},
		function(data){
			if(data.trim() == '1'){
				alert('Mail Sent!');
			}
			else{
				alert('Something went wrong!');
			}
		}
	);
}


