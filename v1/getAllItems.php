<?php 
require_once '../includes/DBOperations.php';
$response = array(); 
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $db = new DBOperations();         
        $news = $db->getAllItems();
        
        $response['news'] =  $news;

    }else{
        $response['error'] = true; 
        $response['message'] = "Error ao tentar carregar lista!";          
    }
echo json_encode($response);