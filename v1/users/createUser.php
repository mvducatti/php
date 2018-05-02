<?php 

require_once '../../includes/DBUserOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

    $user_profile_pic = $_POST['user_profile_pic'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(empty($username) || empty($email) || empty($password) || empty($user_profile_pic)){
        $response['error'] = true;
        $response['message'] = "Por favor preencha todos os campos";
    }else{  
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $db = new DBUserOperations(); 
            $result = $db->createUser($_POST['user_profile_pic'], $_POST['username'], $_POST['email'], $_POST['password']);

            if($result == 1){
                $response['error'] = false; 
                $response['message'] = "Usuario registrado com sucesso";
            }elseif($result == 2){
                $response['error'] = true; 
                $response['message'] = "Algum erro aconteceu, por favor tente novamente em alguns instantes. 
                Se o problema persistir procure o CTI";          
            }elseif($result == 0){
                $response['error'] = true; 
                $response['message'] = "Essa conta ja esta cadastrada, por favor escolha outro usuario ou email";                     
            }

        }else {
            $response['error'] = true;
            $response['message'] = "$email não é um email válido";
        }
    }
    }else{
        $response['error'] = true; 
        $response['message'] = "Invalid Request";
    }

    echo json_encode($response);