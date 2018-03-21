<?php 

require_once '../includes/DBOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(empty($username) || empty($password) || empty($email)){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";

    }else{  

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


            $db = new DBOperations(); 

            $result = $db->createUser($_POST['username'], $_POST['password'], $_POST['email']);

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