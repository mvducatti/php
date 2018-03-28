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
        if($this->isUserRegistered($username,$email)){
            return 0; 
        }else{
            $stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES (NULL, ?, ?, ?);");
            $stmt->bind_param("sss",$username,$password,$email);
            
            if($stmt->execute()){
                return 1; 
            }else{
                return 2; 
            }
        }
    }   

    public function registerItems($product_name, $product_price, $product_origin, $product_status, $user_fk){      
        $stmt = $this->con->prepare("INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_origin`, `product_status`, `flag_visible`, `user_fk`) VALUES (NULL, ?, ?, ?, ?, 1, ?);");
        $stmt->bind_param("sissi", $product_name, $product_price, $product_origin, $product_status, $user_fk);

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

    public function getMyItems($fk_user){

    try{

        $stmt = $this->con->prepare("SELECT product_id, product_name, product_price, product_origin, product_status, flag_visible, user_fk FROM product WHERE user_fk = ? AND flag_visible = 1");

        $stmt->bind_param("i", $fk_user);
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($product_id,$product_name, $product_price, $product_origin, $product_status, 
            $flag_visible, $user_fk);
        $arrayProducts = array();                   
        /* fetch values */
        while ($stmt->fetch()) {
            $temp = array();
            $temp['vendedor'] = $fk_user;
            $temp['product_id'] = $product_id;
            $temp['product_name'] = $product_name;
            $temp['product_price'] = $product_price; 
            $temp['product_origin'] = $product_origin;
            $temp['product_status'] = $product_status;
            $temp['flag_visible'] = $flag_visible; 
            $temp['user_fk'] = $user_fk;  

             
            array_push($arrayProducts, $temp);

        }
        /* close statement */
        $stmt->close();
        return $arrayProducts;
    }catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}


    public function getAllItems(){
        $stmt = $this->con->prepare("SELECT product_id, product_name, product_price, product_origin, product_status, flag_visible, user_fk FROM product WHERE flag_visible = 1");
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($product_id,$product_name, $product_price, $product_origin, $product_status, $flag_visible, $user_fk);
        $arrayProducts = array();                   
        /* fetch values */
        while ($stmt->fetch()) {
            
            
            $temp = array();
            $temp['product_id'] = $product_id;
            $temp['product_name'] = $product_name;
            $temp['product_price'] = $product_price; 
            $temp['product_origin'] = $product_origin;
            $temp['product_status'] = $product_status;
            $temp['flag_visible'] =  $flag_visible; 
            $temp['user_fk'] = $user_fk;  

             
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