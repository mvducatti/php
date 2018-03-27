<?php 
require_once '../includes/DBOperations.php';

	$response = array(); 

	if($_SERVER['REQUEST_METHOD']=='POST'){

	$fk_user = $_POST['fk_user'];


		if(empty($fk_user)){
			$response['error'] = true; 
			$response['message'] = "Por favor preencha todos os campos";

		}else{

			$db = new DBOperations();         
			$products = $db->getMyItems($fk_user);

			$response['products'] =  $products;
		}
	}else{
		$response['error'] = true; 
		$response['message'] = "Error ao tentar carregar lista!";          
	}

echo json_encode($response);