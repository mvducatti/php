<?php 
     
     require_once '../includes/DBOperations.php';
      
     $response = array(); 
      
     if($_SERVER['REQUEST_METHOD']=='POST'){

     $product_id = $_POST['product_id'];
 
         if(empty($product_id)){
         $response['error'] = true; 
         $response['message'] = "Por favor preencha todos os campos";
     } else {
 
         $db = new DBOperations(); 

             $result = $db->sellProduct($_POST['product_id']);
 
             if($result == 1 ){
                 $response['error'] = false; 
                 $response['message'] = "Item Vendido com Sucesso";
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