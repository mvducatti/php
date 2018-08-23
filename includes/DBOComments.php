<?php 

class DBOComments{
   
    private $con; 
    private $res;

    function __construct(){
       
        require_once dirname(__FILE__).'/DBConnect.php';
        
        $db = new DBConnect();
        
        $this->con = $db->connect();
        
    }

    public function registerComment($comment_text, $comment_poster, $comment_newsid){      
        $stmt = $this->con->prepare("INSERT INTO `comments`(`comment_text`, `comment_poster`, `comment_newsid`) 
        VALUES (?,?,?);");
        $stmt->bind_param("sss",$comment_text,$comment_poster,$comment_newsid);       

        if($stmt->execute()){
            return 1; 
        }else{
            return 2; 
        }
    }

    public function getComments($comment_newsfk){
        $stmt = $this->con->prepare("SELECT comment_text, user_profile_pic, username, comment_time FROM comments p INNER JOIN users u ON p.comment_poster = u.user_id 
        WHERE comment_newsid = ?");
        $stmt->bind_param("s", $comment_newsfk);
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($comment_text,$user_profile_pic, $username,$comment_time);
        $arrayComments = array();                   
        /* fetch values */
        while ($stmt->fetch()) {

            $temp = array();
            $temp['comment_text'] = $comment_text;
            $temp['user_profile_pic'] = $user_profile_pic;
            $temp['username'] = $username;
            $temp['comment_time'] = $comment_time;
             
            array_push($arrayComments, $temp);
        }
        /* close statement */
        $stmt->close();
        return $arrayComments;
    }
}