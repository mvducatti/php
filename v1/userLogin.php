<?php 

require_once '../includes/DBOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(empty($_POST['email']) || empty($_POST['password'])){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";
    }else{

        $db = new DBOperations(); 

        if($db->userLogin($_POST['email'], $_POST['password'])){
            $user = $db->getUserByUsername($_POST['email']);
            $response['error'] = false; 
            $response['id'] = $user['id'];
            $response['email'] = $user['email'];
            $response['username'] = $user['username'];
            $response['password'] = $user['password'];  
        }else{
            $response['error'] = true; 
            $response['message'] = "Email ou senha incorretos, por favor verifique se os dados estão corretos";          
        }
    }
}

echo json_encode($response);