    <?php 
     
    require_once '../../includes/DBNewsOperations.php';
     
    $response = array(); 
     
    if($_SERVER['REQUEST_METHOD']=='POST'){

    $news_post = $_POST['news_post'];
    $news_picture = $_POST['news_picture'];
    $user_FK = $_POST['user_FK'];
    $news_group = $_POST['news_group'];

        if(empty($news_post) || empty($user_FK)){
        $response['error'] = true; 
        $response['message'] = "Por favor preencha todos os campos";
    } else {

        $db = new DBNewsOperations(); 
     
            $result = $db->registerNews($_POST['news_post'], $_POST['news_picture'], $_POST['user_FK'], $_POST['news_group']);
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