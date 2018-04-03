<?php 

class DBNewsOperations{
   
    private $con; 
    private $res;

    function __construct(){
       
        require_once dirname(__FILE__).'/DBConnect.php';
        
        $db = new DBConnect();
        
        $this->con = $db->connect();
        
    }

    public function registerNews($news_post, $user_FK){    
        $stmt = $this->con->prepare("INSERT INTO news (news_id, news_post, user_FK) VALUES (NULL, ?, ?);");
        $stmt->bind_param("ss", $news_post, $user_FK);       

        if($stmt->execute()){
            return 1; 
        }else{
            return 2; 
        }
    }

    public function getAllNews(){
        $stmt = $this->con->prepare("SELECT news_id, news_post FROM news");
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($news_id, $news_post);
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

}