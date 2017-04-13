<?php
  class Token {

    /*
    @action: Creates a unique token and stores it in a session variable.
    @eturm: Returns the session variable with the generated token.
    */
    public static function generate() {
      return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }


    /*
    @action: If a token session variable exists, it is compared to another variable to find a match.
    @param $token: The token parameter that we want to compare.
    @return: Returns true if a match exists and false otherwise.
    */
    public static function check($token) {
      $tokenName = Config::get('session/token_name');
      if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
        Session::delete($tokenName);
        return true;
      }

      return false;
    }
  }
?>
