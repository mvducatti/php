<?php
require_once '../includes/DBOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='GET'){

	$vendedor = $_GET['vendedor'];


		if(empty($vendedor)){
			$response['error'] = true;
			$response['message'] = "Por favor preencha todos os campos";
		}else{

			$db = new DBOperations();
			$products = $db->myBiddedItems($vendedor);

			$response['products'] = $products;
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Error ao tentar carregar lista!";
	}

echo json_encode($response);
