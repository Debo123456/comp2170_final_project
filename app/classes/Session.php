<?php
  class Session {
    /*
    @action: Check if a session variables exists, Returns true if the varieble exists and false otherwise.
    @param $name: The name of the session variable we are checking for.
    @return: Return true if variable exista nand false otherwise.
    */
    public static function exists($name) {
      return (isset($_SESSION[$name])) ? true : false;
    }

    /*
    @action: Sets a session variable.
    @param $name: Name of the variable we are setting.
    @param $value: The value of the variable we are settion.
    @return: Returns the session variable we just created.
    */
    public static function put($name, $value) {
      return $_SESSION[$name] = $value;
    }


    /*
    @action: Gets a session variable.
    @param $name: The name of the session variable we are getting.
    @return: Returns the specified session variable.
    */
    public static function get($name) {
      return $_SESSION[$name];
    }


    /*
    @action: Deletes a session variable.
    @param $name: The name of the session variable we want to delete.
    */
    public static function delete($name) {
      if(self::exists($name)) {
        unset($_SESSION[$name]);
      }
    }

  }
?>
