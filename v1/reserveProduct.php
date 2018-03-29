<?php 
     
     require_once '../includes/DBOperations.php';
      
     $response = array(); 
      
     if($_SERVER['REQUEST_METHOD']=='POST'){
 
     $buyer = $_POST['buyer'];
     $product = $_POST['product_id'];
 
         if(empty($buyer) || empty($product)){
         $response['error'] = true; 
         $response['message'] = "Por favor preencha todos os campos";
     } else {
 
         $db = new DBOperations(); 

         echo "$buyer, $product";
             $result = $db->reserveProduct($_POST['buyer'], $_POST['product_id']);
 
             if($result == 1 ){
                 $response['error'] = false; 
                 $response['message'] = "Item Reservado com Sucesso";
             }elseif($result == 2){
                 $response['error'] = true; 
                 $response['message'] = "Some error occurred please try again";          
             }
     }
      
     }else{
         $response['error'] = true; 
         $response['message'] = "Invalid Request";
     }
      
     echo json_encode($response);