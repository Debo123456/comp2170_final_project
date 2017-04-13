<?php

  /*stores array of data that will be used frequently by other scripts,
  good practice for storing database credentials in separate files and in separate location.
  */
  $GLOBALS["config"] = array(
    'mysql' => array(
      'host' => getenv('IP'),  //database host
      'username' => getenv('C9_USER'), //database username
      'password' => '',  //database password
      'db' => 'c9'  //database name
    ),
    'session' => array(
      'session_name' => 'user', //name os session variable that will be used to create user session
      'token_name' => 'token'  //name of session variable to prevent illegal get and post requests
    )
  );

  session_start();

  require_once('classes/Config.php');
  require_once('classes/Session.php');
  require_once('classes/Token.php');
  require_once('classes/Input.php');
  require_once('classes/Validate.php');
  require_once('classes/Hash.php');

  require_once('core/App.php');
  require_once('core/Controller.php');
  require_once('core/DB.php');

?>
