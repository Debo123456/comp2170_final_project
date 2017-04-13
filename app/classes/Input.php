<?php
  class Input {

    /*
      @param $type: String should represent server request method 'post or get', default 'get'.
      @action: Checks if data exists in $_GET or $_POST super globals.
      @return: Returns true if $_POST or $_GET super globals contains data, false otherwise.
    */
    public static function exists($type = 'post') {
      switch($type) {
        case 'post':
          return (!empty($_POST)) ? true : false;
        break;
        case 'get':
          return (!empty($_GET)) ? true : false;
        break;
        default:
          return false;
        break;
      }
    }

    /*
      @param $item: (String) Name of item u want to retreive from a get or post super global.
      @return: if it exists, returns the data() of the $item specified from a get or post super global.
    */
    public static function get($item) {
      if(isset($_POST[$item])) {
        //trim whitespace, if html characters exist in data convert html characters to string representation
        return htmlspecialchars(trim($_POST[$item]), ENT_QUOTES);
      }
      else if(isset($_GET[$item])) {
        //trim whitespace, if html characters exist in data convert html characters to string representation
        return htmlspecialchars(trim($_GET[$item]), ENT_QUOTES);
      }
      return '';
    }
  }
?>
