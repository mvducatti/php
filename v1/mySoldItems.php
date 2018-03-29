<?php
require_once '../includes/DBOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='GET'){

	$buyer_fk = $_GET['buyer_fk'];


		if(empty($buyer_fk)){
			$response['error'] = true;
			$response['message'] = "Nenhum produto vendido";
		}else{

			$db = new DBOperations();
			$products = $db->mySoldItems($buyer_fk);

			$response['products'] = $products;
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Error ao tentar carregar lista!";
	}

echo json_encode($response);
