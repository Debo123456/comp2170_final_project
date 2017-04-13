<?php
  class LoginController extends Controller {
    public function index($post ='') {

            //Get model
            $blog = $this->model('Blog');
            require_once('../app/views/template/header.php');

            //Require the correct view based on the url param
            if($post == 'index.php') {
              $this->view('login/index', ['post' => $post], $blog);
            }

            require_once('../app/views/template/footer.php');


    }
  }
  
?>
