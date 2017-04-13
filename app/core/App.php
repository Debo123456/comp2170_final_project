<?php
    class App {

        protected $controller = 'LoginController'; //Default controller
        protected $method = 'index'; //Default method
        protected $params =[]; //default parameter(No parameters)

        public function __construct() {
            var_dump($_GET['url']);
            //parse url. See parseUrl() function below
            $url = $this->parseUrl();

            //Select controller based on url
            if(file_exists('../app/controllers/' .$url[0]. 'Controller.php')) {//Check if controller exists
              $this->controller = $url[0] . 'controller'; //assign controller to $controller
              unset($url[0]); //remove controller from $url
            }

            require_once('../app/controllers/'.$this->controller.'.php');

            $this->controller = new $this->controller; //Instantiate controller class

            if(isset($url[1])) {
              if(method_exists($this->controller, $url[1])) { //Check if a method exists based on the url
                $this->method = $url[1]; //Assign method if exists
                unset($url[1]); //Remove method from $url
              }
            }

            //if parameters where passed in url assign them to parameter variable otherwise parameter is empty
            $this->params = $url ? array_values($url) : [];

            //Call the method specified by the url within the controller specified by the url.
            call_user_func_array([$this->controller, $this->method], $this->params);
        }

        //Parses a url int an array exploded by '/'
        public function parseUrl() {
            if(isset($_GET['url'])) {
                //explode, sanitize and trim url before assigning
                return $url = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
            else {
                return $url = explode('/',filter_var(rtrim($_POST['url'], '/'), FILTER_SANITIZE_URL));
            }
        }
    }
?>
