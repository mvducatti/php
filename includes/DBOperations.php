<?php 

class DBOperations{
   
    private $con; 
    private $res;

    function __construct(){
       
        require_once dirname(__FILE__).'/DBConnect.php';
        
        $db = new DBConnect();
        
        $this->con = $db->connect();
        
    }
    
    /*CRUD -> C -> CREATE */
    
    public function createUser($username, $password, $email){
        if($this->isUserRegistered($username, $email)){
            return 0; 
        }else{
            $stmt = $this->con->prepare("INSERT INTO users (id, username, password, email) VALUES (NULL, ?, ?, ?);");
            $stmt->bind_param("sss", $username, $password, $email);
            
            if($stmt->execute()){
                return 1; 
            }else{
                return 2; 
            }
        }
    }   

    public function registerItems($product_name, $product_price, $product_origin, $product_status, $seller_fk){      
        $stmt = $this->con->prepare("INSERT INTO product (product_id, product_name, product_price, product_origin, 
        product_status, seller_fk, buyer_id, selling_status) VALUES (NULL, ?, ?, ?, ?, ?, null, 0);");
        $stmt->bind_param("sissi", $product_name, $product_price, $product_origin, $product_status, $seller_fk);

        if($stmt->execute()){
            return 1; 
        }else{
            return 2; 
        }
    }

    public function reserveProduct ($buyer, $product_id){      
        $stmt = $this->con->prepare("UPDATE product SET buyer_id = ? WHERE product_id = ?");
        $stmt->bind_param("ii", $buyer, $product_id);

        if($stmt->execute()){
            return 1; 
        }else{
            return 2; 
        }
    }

    public function userLogin($email, $password){
        $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email,$password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt-> num_rows > 0;
    }

    public function myBiddedItems($vendedor_id){
        $stmt = $this->con->prepare("SELECT product_id, product_name, product_price, product_origin, product_status, selling_status, s.email 
        FROM product  as p left JOIN users as s on p.buyer_id = s.id 
        WHERE seller_fk = ? AND buyer_id IS NOT NULL AND selling_status = 0");
        $stmt->bind_param("i", $vendedor_id);
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($product_id, $product_name, $product_price, $product_origin, $product_status, 
            $selling_status,$email);
        $arrayProducts = array();                   
        /* fetch values */
        while ($stmt->fetch()) {
            $temp = array();
            $temp['vendedor'] = $vendedor_id;
            $temp['product_id'] = $product_id;
            $temp['product_name'] = $product_name;
            $temp['product_price'] = $product_price; 
            $temp['product_origin'] = $product_origin;
            $temp['product_status'] = $product_status;
            $temp['selling_status'] = $selling_status;
            $temp['interessado'] = $email;
             
            array_push($arrayProducts, $temp);

        }

        /* close statement */
        $stmt->close();
        return $arrayProducts;
}


    public function getMyReservations($buyer_fk){
        $stmt = $this->con->prepare("SELECT product_id, product_name, product_price, product_origin, product_status, selling_status, 
        buyer_id FROM product WHERE buyer_id = ? AND selling_status = 0");
        $stmt->bind_param("i", $buyer_fk);
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($product_id,$product_name, $product_price, $product_origin, $product_status, 
            $selling_status, $seller_fk);
        $arrayProducts = array();                   
        /* fetch values */
        while ($stmt->fetch()) {
            $temp = array();
            $temp['comprador'] = $buyer_fk;
            $temp['vendedor'] = $seller_fk;
            $temp['product_id'] = $product_id;
            $temp['product_name'] = $product_name;
            $temp['product_price'] = $product_price; 
            $temp['product_origin'] = $product_origin;
            $temp['product_status'] = $product_status;
             
            array_push($arrayProducts, $temp);

        }

        /* close statement */
        $stmt->close();
        return $arrayProducts;
}

    public function getMyItems($seller_fk){
        $stmt = $this->con->prepare("SELECT product_id, product_name, product_price, product_origin, product_status, selling_status, 
        seller_fk FROM product WHERE seller_fk = ? AND selling_status = 0");
        $stmt->bind_param("i", $seller_fk);
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($product_id,$product_name, $product_price, $product_origin, $product_status, 
            $flag_visible, $seller_fk);
        $arrayProducts = array();                   
        /* fetch values */
        while ($stmt->fetch()) {
            $temp = array();
            $temp['vendedor'] = $seller_fk;
            $temp['product_id'] = $product_id;
            $temp['product_name'] = $product_name;
            $temp['product_price'] = $product_price; 
            $temp['product_origin'] = $product_origin;
            $temp['product_status'] = $product_status;
             
            array_push($arrayProducts, $temp);

        }

        /* close statement */
        $stmt->close();
        return $arrayProducts;
}

    public function getAllItems(){
        $stmt = $this->con->prepare("SELECT product_id, product_name, product_price, product_origin, product_status, 
        seller_fk, selling_status FROM product WHERE buyer_id is null");
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($product_id, $product_name, $product_price, $product_origin, $product_status, $seller_fk, $selling_status);
        $arrayProducts = array();                   
        /* fetch values */
        while ($stmt->fetch()) {
            
            
            $temp = array();
            $temp['product_id'] = $product_id;
            $temp['product_name'] = $product_name;
            $temp['product_price'] = $product_price; 
            $temp['product_origin'] = $product_origin;
            $temp['product_status'] = $product_status;
            $temp['seller_fk'] = $seller_fk;  

             
            array_push($arrayProducts, $temp);

        }
        /* close statement */
        $stmt->close();
        return $arrayProducts;
    }


    public function getUserByUsername($email){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    
    private function isUserRegistered($username, $email){
        $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute(); 
        $stmt->store_result(); 
        return $stmt->num_rows > 0; 
    }
    
}