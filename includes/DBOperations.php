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
        $stmt = $this->con->prepare("INSERT INTO `product` (`news_id`, `product_name`, `product_price`, `product_origin`, `product_status`, `flag_visible`, `user_fk`) VALUES (NULL, ?, ?, ?, ?, 1, ?);");
        $stmt->bind_param("sssss",$product_name, $product_price, $product_origin, $product_status, $user_fk);

        if($stmt->execute()){
            return 1; 
        }else{
            return 2; 
        }
    }

    public function userLogin($username, $password){
        $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username,$password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt-> num_rows > 0;
    }

    public function getAllItems(){
        $stmt = $this->con->prepare("SELECT news_id, news_post FROM news");
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($news_id,$news_post);
        $arrayNews = array();                   
        /* fetch values */
        while ($stmt->fetch()) {

            $temp = array();
            $temp['id'] = $news_id; 
            $temp['noticia'] = $news_post; 
             
            array_push($arrayNews, $temp);

        }
        /* close statement */
        $stmt->close();
        return $arrayNews;
    }

    public function getUserByUsername($username){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s",$username);
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