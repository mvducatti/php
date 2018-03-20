<?php 

require_once '../includes/DBOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
        $db = new DBOperations(); 

        if($db->userLogin($_POST['username'], $_POST['password'])){
            $user = $db->getAllNews($_POST['username']);
            $response['error'] = false; 
            $response['id'] = $user['id'];
            $response['email'] = $user['email'];
            $response['username'] = $user['username'];



                                                                                $news = array ();

                                                                            while($stmt->fetch()){
                                                                                 $temp = array();
                                                                                 $temp['id'] = $id; 
                                                                                 $temp['news_post'] = $news_post;
                                                                                 array_push($products, $temp);
                                                                            }



        }else{
            $response['error'] = true; 
            $response['message'] = "Usuario ou senha incorretos, por favor verifique novamente";          
        }
}

echo json_encode($response);