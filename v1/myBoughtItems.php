<?php
require_once '../includes/DBOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='GET'){

	$buyer_fk = $_GET['buyer_fk'];


		if(empty($buyer_fk)){
			$response['error'] = true;
			$response['message'] = "Nenhum produto comprado";
		}else{

			$db = new DBOperations();
			$products = $db->myBoughtItems($buyer_fk);

			$response['products'] = $products;
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Error ao tentar carregar lista!";
	}

echo json_encode($response);
