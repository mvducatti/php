    <?php 
     
    require_once '../includes/DBOperations.php';
     
    $response = array(); 
     
    if($_SERVER['REQUEST_METHOD']=='POST'){

    $product_name = $_POST['product_name'];
    $product_origin = $_POST['product_origin'];
    $product_status = $_POST['product_status'];
    $product_price = $_POST['product_price'];
    $seller_fk = $_POST['seller_fk'];

        if(empty($product_name) || empty($product_price)){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";
    } else {

        $db = new DBOperations(); 
     
            $result = $db->registerItems($_POST['product_name'], $_POST['product_price'], $_POST['product_origin'], 
            $_POST['product_status'], $_POST['seller_fk']);

            if($result == 1 ){
                $response['error'] = false; 
                $response['message'] = "Item Registrado com sucesso";
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