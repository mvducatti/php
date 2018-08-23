<?php 

require_once '../../includes/DBOComments.php';

$response = array(); 

    if($_SERVER['REQUEST_METHOD']=='GET'){

        $comment_newsfk = $_GET['comment_newsfk'];

        $db = new DBOComments();        
        $comments = $db->getComments($comment_newsfk);
        
        $response['comments'] =  $comments;

    }else{
        $response['error'] = true; 
        $response['message'] = "Error ao tentar os comentários!";          
    }
echo json_encode($response);