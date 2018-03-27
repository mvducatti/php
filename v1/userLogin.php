<?php 

require_once '../includes/DBOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";
    }else{

        $db = new DBOperations(); 

        if($db->userLogin($_POST['username'], $_POST['password'])){
            $user = $db->getUserByUsername($_POST['username']);
            $response['error'] = false; 
            $response['id'] = $user['id'];
            $response['email'] = $user['email'];
            $response['username'] = $user['username'];
            $response['password'] = $user['password'];  
        }else{
            $response['error'] = true; 
            $response['message'] = "Usuario ou senha incorretos, por favor verifique se os dados estão corretos";          
        }
    }
}

echo json_encode($response);