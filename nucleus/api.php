<?php session_start() ?>
<?php 
$redirect = 'index.php';
if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in']==1)){}
else{ header("location:$redirect"); }
?>
<?php include_once '../connect.php' ?>
<?php 
if(isset($_GET['action'])){
	$function = $_GET['action'];
	$function();
}

function add_item(){
	
	// application/octet-stream 
	// application/pdf
	// print_r($_POST);
	// print_r($_FILES);
	
	global $con;
	$product = $_POST; 
	$ftype = $_FILES["attachment"]["type"];
	$fname = time() . '_' . basename($_FILES["attachment"]["name"]);
	
	//if($ftype == 'application/octet-stream' || $ftype == 'application/pdf'){
                    if(1){
		try{ 
			$target_dir = "../store/files/";
			$target_file = $target_dir . $fname; 
			
			if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
				
			} else {
				echo "Sorry, there was an error uploading your file.<a href='./dashboard.php'>Back</a>";
				die();
			}
		
			$insStmt = $con->prepare("insert into products(title,description,file_name) values(:title,:description,:file_name)");  
			$insStmt->bindParam(':title',$product["title"]);
			$insStmt->bindParam(':description',$product["description"]);
			$insStmt->bindParam(':file_name',$fname);
			$insStmt->execute();
			$product_id = $con->lastInsertId();
			
			$insStmt = $con->prepare("insert into products_tags(product_id,tag_id) values(:pid,:tid)");  
			foreach($product["tags"] as $tag_id){
				if(intval($tag_id) == 0)
					$tag_id = save_tag($tag_id);
				$insStmt->bindParam(':pid',$product_id);
				$insStmt->bindParam(':tid',$tag_id);
				$insStmt->execute();
			}
			header("location: dashboard.php");
		}
		catch(Exception $e){
			if(intval($con->inTransaction()) == 1)
				$con->rollBack(); 
			echo "Sorry, there was an error.<a href='./dashboard.php'>Back</a>";
			die();
		}
	}
	else{
		echo "Invalid file type.<a href='./dashboard.php'>Back</a>";
		die();
	}
	
}

function del_item(){
	global $con;
	$data = 0;
	try{ 
		$target_dir = "../store/files/";
		$prod = get_products(array($_POST['id']));
		unlink($target_dir.$prod[0]['file_name']);
		
		$delStmt = $con->prepare("delete from products where id = :id");  
		$delStmt->bindParam(':id',$_POST['id']);
		$delStmt->execute(); 
		$data = 1;
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	echo $data;
}

function get_products($ids = []){

	global $con;
	$data = [];
	try{
		$conditions = '';
		if(count($ids)){
			$conditions = " where products.id IN(".implode(',',$ids).")";
		}
		$selStmt = $con->prepare("select * from products".$conditions);  
		$selStmt->execute();
		$data = ($selStmt->fetchAll(PDO::FETCH_ASSOC));
		foreach($data as $key=>$obj){
			$selStmt = $con->prepare("select tags.id,tags.name from products_tags 
									  left join tags on tags.id = products_tags.tag_id 
									  where products_tags.product_id = ".$obj['id'].""); 
			$selStmt->execute();
			$data[$key]['tags'] = $selStmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	return $data;

}

function get_tags($ids = []){
	global $con;
	$data = [];
	try{
		$conditions = '';
		if(count($ids)){
			$conditions = " where id IN(".implode(',',$ids).")";
		}
		$selStmt = $con->prepare("select * from tags".$conditions);  
		$selStmt->execute();
		$data = ($selStmt->fetchAll(PDO::FETCH_ASSOC));
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	return $data;
}

function get_tag_id($name){
	global $con;
	$data = 0;
	try{ 
		$selStmt = $con->prepare("select id from tags where name = :name");  
		$selStmt->bindParam(':name',$name);
		$selStmt->execute();
		$rs = $selStmt->fetchAll(PDO::FETCH_ASSOC);
		$data = $rs[0]['id'];
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	return $data;
}

function save_tag($name){
	global $con;
	$data = 0;
	try{ 
		$insStmt = $con->prepare("insert ignore into tags(name) values(:name)");  
		$insStmt->bindParam(':name',$name);
		$insStmt->execute();
		$data = get_tag_id($name);
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	return $data;
}

?>