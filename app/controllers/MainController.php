<?php
  class MainController extends Controller {
    public function index() {

            //Get model
            
            require_once('../app/views/template/header.php');

            //Require the correct view based on the url param
             $this->view('dashboard/index');

            require_once('../app/views/template/footer.php');


    }
  }
  
?>