<?php 

require_once '../../includes/DBUserOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(empty($_POST['email']) || empty($_POST['password'])){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";
        
    }else{

        $db = new DBUserOperations(); 

        if($db->userLogin($_POST['email'], $_POST['password'])){
            $user = $db->getUserByEmail($_POST['email']);
            $response['error'] = false; 
            $response['user_id'] = $user['user_id'];
            $response['email'] = $user['email'];
            $response['name'] = $user['username'];
            $response['photo'] = $user['user_profile_pic'];
            $response['message'] = "Login Efetuado com sucesso!"; 
        }else{
            $response['error'] = true; 
            $response['message'] = "Email ou senha incorretos, por favor verifique se os dados estão corretos";          
        }
    }
}

echo json_encode($response);