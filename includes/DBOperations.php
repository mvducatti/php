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

    public function registerNews($news_post, $user_FK){      
        $stmt = $this->con->prepare("INSERT INTO `news` (`news_id`, `news_post`, `user_FK`) VALUES (NULL, ?, ?);");
        $stmt->bind_param("ss",$news_post,$user_FK);       

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

    public function getAllNews(){
        $stmt = $this->con->prepare("SELECT news_post FROM news");
        $stmt->execute();
            /* bind result variables */
                $stmt->bind_result($news_post);

            /* fetch values */
            while ($stmt->fetch()) {
                printf ("%s\t", $news_post);
            }

            /* close statement */
            $stmt->close();
        

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