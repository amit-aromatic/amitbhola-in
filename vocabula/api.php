<?php include '../connect.php' ?>
<?php require_once './mailer/PHPMailerAutoload.php'; ?>
<?php
function fetch_these_from_db($ids = array()){
	global $con;
	$data = array();
	$ids = implode(',',$ids);
	try{
		$from_language 	= $_SESSION['from_language'];
		$to_language   	= $_SESSION['to_language'];
		
		$selStmt = $con->prepare("select $from_language,$to_language from vocabula where id IN($ids)"); 
		// $selStmt->bindParam(':ids',$ids);
		$selStmt->execute();
		// echo $selStmt->rowCount();
		$data = ($selStmt->fetchAll(PDO::FETCH_ASSOC));
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	return $data;
}

function get_all_in_session(){
	global $con;
	$all_in_session = array();
	
	try{
		$from_language 	= $_SESSION['from_language'];
		$to_language   	= $_SESSION['to_language'];
		// $all_in_session	= $_SESSION['word_series']['series']; 
		$all_in_session	= array_filter($_SESSION['word_series']['covered']); 
		// echo count($all_in_session);
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $all_in_session;
	} 
	return $all_in_session;
}

function get_forgotten(){
	global $con;
	$forgot = array();
	
	try{
		$from_language 	= $_SESSION['from_language'];
		$to_language   	= $_SESSION['to_language'];
		$word_series   	= $_SESSION['word_series'];
		$forgot		   	= $word_series['forgot'];
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $forgot;
	} 
	
	return $forgot;
}

function run_forgot(){
	
	$forgot = get_forgotten();
	shuffle($forgot);
	
	$new_word_series 				= array();
	$new_word_series['series']		= $forgot;
	$new_word_series['forgot']		= array();
	$new_word_series['covered']		= array();
	$new_word_series['current']		= 0;
	$new_word_series['total']		= count($forgot);
	$new_word_series['score']		= 0;
	
	$_SESSION['word_series'] 		= $new_word_series;
}

function set_word_series(){
	global $con;
	$from_language = $_SESSION['from_language'];
	$to_language   = $_SESSION['to_language'];
	
	$word_series 				= array();
	$word_series['series']		= array();
	$word_series['forgot']		= array();
	$word_series['covered']		= array();
	$word_series['current']		= 0;
	$word_series['total']		= 0;
	$word_series['score']		= 0;
	
	try{
		$selStmt = $con->prepare("select id from vocabula where $from_language is not null and $to_language is not null order by id asc"); 
		$selStmt->execute();
		$series = array();
		if($selStmt->rowCount() > 0){
			while($row = $selStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
				$series[] = $row['id'];
		} else {
			return 0;
		}
		shuffle($series);
		$word_series['series'] 	= $series;
		$word_series['total']  	= $selStmt->rowCount();
		$_SESSION['word_series'] = $word_series;
		return json_encode($word_series);
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return 0;
	} 
}

function print_session_series(){
	echo '<pre>'; print_r($_SESSION['word_series']); echo'</pre>';
}

function get_prev_words_from_session(){
	global $con;
	
	try{
		$word_series = $_SESSION['word_series'];
		$series 	 = $word_series['series'];
		$current 	 = $word_series['current'];
		
		$start = 0;
		
		
		$length = $current-$start;
		
		// echo $current;
		// echo '--';
		// echo $start;
		// echo '--';
		// echo $length;
		
		$start = ($current - 8)+1;
		if($start<0){
			$start = 0;
		}
		
		$length = $current - $start; 
		
		if ($length < 0){
			$length = 0;
		}
		
		$needed_ids  = implode(',',array_reverse(array_slice($series,$start,$length+1))); 
		
		if(count($needed_ids)>0){
			$selStmt = $con->prepare("select * from vocabula where id IN(".$needed_ids.") order by FIELD(id,".$needed_ids.")");
			$selStmt->execute();
			if($selStmt->rowCount() > 0){
				$words = array();
				$cnt   = 0;
				while($word = $selStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
					$words[$cnt]['word'] 			= $word;
					$words[$cnt]['from_language'] 	= $_SESSION['from_language'];
					$words[$cnt++]['to_language']   	= $_SESSION['to_language']; 
				}
				// $words['finished'] = 0;
				return json_encode($words); 
			}
			else{
				$return_array = array();
				$return_array['finished'] = 1; 
				return json_encode($return_array);
			} 
		}
		else{
			$return_array = array();
			$return_array['finished'] = 1;
			
			return json_encode($return_array);
		}
		
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return 0; 
	} 

}

function get_next_words_from_session(){
	global $con;
	
	try{
		$word_series = $_SESSION['word_series'];
		$series 	 = $word_series['series'];
		$current 	 = $word_series['current'];
		
		// echo $current;
		// echo '--';
		
		$needed_ids  = implode(',',array_slice($series,$current,8)); 
		
		if(count($word_series['covered']) < count($word_series['series'])){
			$selStmt = $con->prepare("select * from vocabula where id IN(".$needed_ids.") order by FIELD(id,".$needed_ids.")");
			$selStmt->execute();
			if($selStmt->rowCount() > 0){
				$words = array();
				$cnt   = 0;
				while($word = $selStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
					$words[$cnt]['word'] 			= $word;
					$words[$cnt]['from_language'] 	= $_SESSION['from_language'];
					$words[$cnt++]['to_language']  	= $_SESSION['to_language']; 
				}
				// $words['finished'] = 0;
				return json_encode($words); 
			}
			else{
				$return_array = array();
				$return_array['finished'] = 1; 
				return json_encode($return_array);
			} 
		}
		else{
			$return_array = array();
			$return_array['finished'] = 1;
			
			return json_encode($return_array);
		}
		
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return 0; 
	} 

}

function get_current_word_from_session(){
	global $con;
	
	try{
		
		$word_series = $_SESSION['word_series'];
		$series 	 = $word_series['series'];
		$current 	 = $word_series['current'];
		
		if(count($word_series['covered']) < count($word_series['series'])){ 
			$selStmt = $con->prepare("select * from vocabula where id = :id limit 1"); 
			$selStmt->bindParam(':id',$series[$current]); 
			$selStmt->execute();
			if($selStmt->rowCount() > 0){
				$word = $selStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
				$word['word'] 			= $word;
				$word['from_language'] 	= $_SESSION['from_language'];
				$word['to_language']   	= $_SESSION['to_language'];
				// $word['finished']   	= 0;
				
				return json_encode($word); 
			}
			else{
				return 0;
			} 
		}
		else{
			$return_array = array();
			$return_array['finished'] = 1;
			
			return json_encode($return_array);
		}
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return 0; 
	} 
	
}

function mark_forgot_in_session(){
	
	$word_series = $_SESSION['word_series'];
	$series 	 = $word_series['series'];
	$current 	 = $word_series['current'];
	$forgot 	 = $word_series['forgot'];
	
	$forgot[] 	 = $series[$current];
	$_SESSION['word_series']['forgot'] 	= array_unique($forgot); 
	mark_covered_in_session();

}

function mark_covered_in_session(){
	
	$word_series = $_SESSION['word_series'];
	$series 	 = $word_series['series'];
	$current 	 = $word_series['current'];
	$covered 	 = $word_series['covered'];
	
	$covered[] 	= $series[$current];
	$_SESSION['word_series']['covered'] 	= array_unique($covered); 
	$_SESSION['word_series']['current'] 	= ++$current;
	// return get_current_word_from_session();
	
}

function get_prev_word_from_session(){
	$word_series = $_SESSION['word_series'];
	$current 	 = $word_series['current'];
	$_SESSION['word_series']['current'] = --$current;
	if($_SESSION['word_series']['current'] < 0)
		$_SESSION['word_series']['current'] = 0;
	
	// return get_current_word_from_session(); 
}

function refresh_meta_data(){
	
	$word_series = $_SESSION['word_series'];
	$series 	 = $word_series['series'];
	$current 	 = $word_series['current'];
	$forgot 	 = $word_series['forgot'];
	$covered 	 = $word_series['covered'];
	
	$covered_from_client 	= json_decode($_POST['covered'],true);
	$forgot_from_client		= json_decode($_POST['forgot'],true);
	$current_from_client 	= $_POST['current'];
	
	foreach($covered_from_client as $cc){
		$covered[] 	= $series[$cc];
	}
	
	foreach($forgot_from_client as $cc){
		$forgot[] 	= $series[$cc];
	}
	
	$current 	= $current_from_client;
	
	// $covered[] 	= $series[$current];
	$_SESSION['word_series']['covered'] 	= array_filter(array_values(array_unique($covered))); 
	$_SESSION['word_series']['forgot'] 		= array_filter(array_values(array_unique($forgot)));  
	$_SESSION['word_series']['current'] 	= ($current); 
	// $_SESSION['word_series']['current'] 	= ++$current;
	// return get_current_word_from_session();
}

function display_all(){
	echo email_all();
	echo print_in_table(fetch_these_from_db(get_all_in_session()));
}

function email_all(){
	$html = '';
	$html.= '<br><input placeholder="Enter your Email" id="email_all" type="text" /> <input onclick="send_all()" value="Send" type="button" class="btn"><br><br>';
	return $html;
}

function send_all(){
	global $mail_user;
	global $mail_pass;
	global $mail_host;
	
	$email_content = "Here is your requested list of words:<br>";
	$email_content .= print_in_table(fetch_these_from_db(get_all_in_session()));
	
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = $mail_host;
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = true;
	$mail->Username = $mail_user;
	$mail->Password = $mail_pass;
	$mail->setFrom($mail_user, 'amitbhola.in');
	$mail->addReplyTo('amit_aromatic@yahoo.com', 'Amit Bhola');
	$mail->addAddress($_POST['email']);
	$mail->Subject = 'Requested word list';
	$mail->msgHTML($email_content);
	
	// var_dump($mail);
	
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo 1;
	}
}

function display_forgotten(){
	echo email_forgotten();
	echo print_in_table(fetch_these_from_db(get_forgotten()));
}

function email_forgotten(){
	$html = '';
	$html.= '<br><input placeholder="Enter your Email" id="email_forgotten" type="text" /> <input onclick="send_forgotten()" value="Send" type="button" class="btn"><br><br>';
	return $html;
}

function send_forgotten(){
	global $mail_user;
	global $mail_pass;
	global $mail_host;
	
	$email_content = "Here is your requested list of words:<br>";
	$email_content .= print_in_table(fetch_these_from_db(get_forgotten()));
	
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = $mail_host;
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = true;
	$mail->Username = $mail_user;
	$mail->Password = $mail_pass;
	$mail->setFrom($mail_user, 'amitbhola.in');
	$mail->addReplyTo('amit_aromatic@yahoo.com', 'Amit Bhola');
	$mail->addAddress($_POST['email']);
	$mail->Subject = 'Requested word list';
	$mail->msgHTML($email_content);
	
	// var_dump($mail);
	
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo 1;
	}
	
}

function print_in_table($resultSet = array()){
	$html = '';
	$html.= '<table style="border-collapse:collapse;width:80%;margin: 0 auto;" cellpadding="5" cellspaciong="0" border="1">'; 
		foreach($resultSet as $row){
			$html.= '<tr>';
				$html.= "<th style='padding:5px;'>Sno</th>"; 
				foreach($row as $key=>$value){
					$html.= "<th style='padding:5px;'>".ucwords($key)."</th>"; 
				}
			$html.= '</tr>';
			break;
		}
		
		foreach($resultSet as $ii=>$row){
			$html.= '<tr>';
				$html.= "<td style='padding:5px;'>".($ii+1)."</td>"; 
				foreach($row as $key=>$value){
					$html.= "<td style='padding:5px;text-align:left;'>$value</td>"; 
				}
			$html.= '</tr>';
		}
	$html.= '</table>'; 
	
	return $html; 
}

?>

