<?php 

require_once '../includes/DBOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='GET'){
        $db = new DBOperations();         
        $user = $db->getAllNews();

            
        }else{
            $response['error'] = true; 
            $response['message'] = "Usuario ou senha incorretos, por favor verifique novamente";          
        }


//echo json_encode($response);