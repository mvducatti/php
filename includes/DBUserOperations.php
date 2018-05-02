<?php 

class DBUserOperations{
   
    private $con; 
    private $res;

    function __construct(){
       
        require_once dirname(__FILE__).'/DBConnect.php';
        
        $db = new DBConnect();
        
        $this->con = $db->connect();
        
    }

    public function createUser($user_profile_pic, $username, $email, $password){
        if($this->isUserRegistered($email)){
            return 0; 
        }else{
            
            $stmt = $this->con->prepare("INSERT INTO users (user_profile_pic, username, email, password, 
            user_date_created) VALUES (?, ?, ?, ?, NOW() );"); 
            $stmt->bind_param("ssss", $user_profile_pic, $username, $email, $password);

            if($stmt->execute()){
                return 1;
            }else{
                return 2; 
            }
        }
    }

    public function userLogin($email, $password){
        $stmt = $this->con->prepare("SELECT user_id FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt-> num_rows > 0;
    }

    public function getUserByEmail($email){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    
    private function isUserRegistered($email){
        $stmt = $this->con->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute(); 
        $stmt->store_result(); 
        return $stmt->num_rows > 0; 
    }

}