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
        $stmt = $this->con->prepare("INSERT INTO news (news_id, news_post, news_date_created, news_poster) 
            VALUES (NULL, ?, NOW(), ?);");
        $stmt->bind_param("ss", $news_post, $user_FK);       

        if($stmt->execute()){
            return 1; 
        }else{
            return 2; 
        }
    }

    public function getAllNews(){
        $stmt = $this->con->prepare("SELECT `news_id`, `news_post`, `news_date_created`, `news_poster`, 
        users.user_profile_pic, users.username, users.email  
        FROM `news` 
        INNER JOIN users on news.news_poster = users.user_id");
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($news_id, $news_post, $news_date_created, $news_poster, 
        $users_user_profile_pic, $users_username, $users_email);
        $arrayNews = array();                   
        /* fetch values */
        while ($stmt->fetch()) {

            $temp = array();
            $temp['news_id'] = $news_id; 
            $temp['news_post'] = $news_post; 
            $temp['news_poster'] = $news_poster;
            $temp['news_date_created'] = $news_date_created;
            $temp['users.username'] = $users_username;
            $temp['users.email'] = $users_email;
            $temp['users.user_profile_pic'] = $users_user_profile_pic;
             
            array_push($arrayNews, $temp);

        }
        /* close statement */
        $stmt->close();
        return $arrayNews;
    }

}