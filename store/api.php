<?php session_start() ?>
<?php 
if((@include_once '../connect.php') === false)
{
    include_once './connect.php';
}
?>
<?php 
if(isset($_GET['action'])){
	$function = $_GET['action'];
	$function();
}

function get_products_cnt(){
	global $con;
	$data = 0;
	try{
		
		$selStmt = $con->prepare("select count(id) as cc from products");  
		$selStmt->execute();
		$data = ($selStmt->fetchAll(PDO::FETCH_ASSOC));
		foreach($data as $key=>$obj){
			$data = $obj['cc'];
		}
	}
	catch(Exception $e){
		if(intval($con->inTransaction()) == 1)
			$con->rollBack();
		return $data;
	} 
	return $data;
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
		// $selStmt = $con->prepare("select * from tags".$conditions);  
		$selStmt = $con->prepare("SELECT count(product_id) as prod_cnt, tags.id, tags.name 
								FROM `products_tags` 
								left join tags on tags.id = products_tags.tag_id $conditions 
								group by tags.id
								order by tags.name");  
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

?>