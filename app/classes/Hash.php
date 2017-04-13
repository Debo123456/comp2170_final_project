<?php
  class Hash {
    /*
      @param $string: The string we wish to hash, for this project this string will be a password.
      @param $salt: String used for salting in the hash function.
    */
   public static function make($string, $salt = '') {
     return hash('sha256', $string . $salt);
   }

   //Returns random string, which we use for salting
   public static function salt() {
     return uniqid();
   }
  }
?>
