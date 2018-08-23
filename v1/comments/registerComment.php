    <?php 
     
    require_once '../../includes/DBOComments.php';
     
    $response = array(); 
     
    if($_SERVER['REQUEST_METHOD']=='POST'){

    $comment_text = $_POST['comment_text'];
    $comment_poster = $_POST['comment_poster'];
    $comment_newsid = $_POST['comment_newsid'];

        if(empty($comment_text) || empty($comment_poster) || empty($comment_newsid)){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";

    } else {

        $db = new DBOComments();
     
            $result = $db->registerComment($_POST['comment_text'], $_POST['comment_poster'], $_POST['comment_newsid']);
            if($result == 1 ){
                $response['error'] = false; 
                $response['message'] = "Noticia Registrada com sucesso";
            }elseif($result == 2){
                $response['error'] = true; 
                $response['message'] = "Deu ruim";          
            }
    }
     
    }else{
        $response['error'] = true; 
        $response['message'] = "Invalid Request";
    }
     
    echo json_encode($response);