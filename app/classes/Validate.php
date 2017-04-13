<?php
class Validate {
  private $_passed = false,
          $_errors = array(),
          $_db = null;

  //Constructor creates an instance of our DB class, stores pdo object for database in $_db variable.
  public function __construct() {
    $this->_db = DB::getInstance();
  }

  /*
    @param $items: Nested multidemensional array. First array has a string which is the name of a post variable as key
      and an array() as value. Inner array has a string containing a specific rule we want to validate against as key
      and the condition for the validation as value.
      e.g array(
        'username' => array(
          'required' => true;
        )
      )
      The above code means the username post variable has the required rule set to true, which means it
      should not be empty.
      If a specific rule is not met an error is added to the $_errors array using the addError() function.
      If all rules are met sets the $_passed variable to true.
  */
  public function check($items = array()) {
    foreach ($items as $item => $rules) {
      foreach ($rules as $rule => $rule_value) {
        $value = Input::get($item);

        switch($item) {
          case 'postTitle':
            $item = 'Title';
            break;

          case 'postDesc':
            $item = 'Description';
            break;

          case 'postCont':
            $item = 'Post Content';
            break;

        }


        if($rule === 'required'  && empty($value)) {
          $this->addError("{$item} is required"); //Adds an error if a required field is empty.
        }
        else if(!empty($value)) {
          switch($rule) {
            case 'unique':
              $check = $this->_db->get('users', array('username', '=', $value)); //Check if username already exists.
              if(count($this->_db->results())) {
                $this->addError("{$item} already exists."); //Adss an error if user already exists.
              }
            break;

            case 'characters':
            if(!preg_match($rule_value,$value)) //If the chaacters rule is set, matches input agains a specified regular expression.
            {
              if($item == 'password') {
                $this->addError("{$item} should be atleast 8 characters and contain a number, capital letter and special character, e.g @$!%*#?&");
              } else {
                  $this->addError("Invalid {$item}"); //Adds error if input does not match regex.
              }

            }
            break;
            case 'matches': //The confirm password input will usually have this rule.
              if($value != Input::get('password')) { //Checks if passwords match.
                $this->addError("Passwords must match"); //Adds error if passwords do not match.
            }
            break;

            case 'default':
              if($value == $rule_value) {
                $this->addError("You must select a {$item}");
              }
          }
        }

      }
    }

    if(empty($this->_errors)) {
      $this->_passed = true;
    }
    return $this;
  }

  /*
    @param $error: String containing error message.
    @action: Adds error message string to the $_errors array
  */
  private function addError($error) {
    $this->_errors[] = $error;
  }

  /*
    @return: Returns $_errors array.
  */
  public function errors() {
    return $this->_errors;
  }


  /*
    @return: Returns passed variable
  */
  public function passed() {
    return $this->_passed;
  }
}

?>
