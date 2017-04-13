<?php

  /*Class used to access configuration files that we have stored in the
  $GLOBALS super global.
  See core/init.php
  */
  class Config
  {
    /*
      @action: Retreives values we store in the $GLOBALS super global.
      @param: String of the value name we want to retreive e.g('mysql/host').
      @returns: Returns the specified value from the $GLOBALS variable, false if the value wasnt found.
    */
    public static function get($path = null)
    {
      if($path)
      {

        $config = $GLOBALS['config'];
        $path = explode('/', $path);  //Assigns an array to $path containing the values of the $path string exploded by '/'.

        foreach ($path as $bit) {  //Loops throug $GLOBALS to find requested values.
          if (isset($config[$bit])) {
            $config = $config[$bit];
          }
          else{
            return false;
          }
        }

        return $config;

      }
    }
  }

?>
