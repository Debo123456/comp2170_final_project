<?php
class User {
  private $_db, $_data, $_sessionName, $_isLoggedIn;

  /*
  Constructor retreives an instance of the DB class.
  @return: PDO object of our database.
  */
  public function __construct($user = null) {
    $this->_db = DB::getInstance();
    $this->_sessionName = Config::get('session/session_name');

    if(Session::exists($this->_sessionName)) { //Check if user id is stored in the session
        $user = Session::get($this->_sessionName); //Assign user id to $user variable.

        if($this->find($user)) { //Search for user in database and store user information.
          $this->_isLoggedIn = true;
        }
        else {
          // process Logout
          $this->logout();
        }

    } else {
      $this->find($user);
    }

  }

  /*
    @param: Multi-dimensional array of the database fields as the key and the correspomdimg values we wish to store as the value;
    @action: Inserts new user information into database if successful.
  */
  public function create($fields = array()) {
    var_dump('created');
    if(!$this->_db->insert("`c9`.`users`", $fields)) {
      throw new Exception('There was a problem creating an account');
    }
  }

  /*
    @action: Searches the database for a user and stores there information in the $_data variable.
    @param $user: (String) Can either be a username or an email address.
    @return: returns true if the username or email address if found in the database false otherwise.
  */
  public function find($user = null) {
    if($user) {
      //Uses regular expression to determine if the parameter is an email address
      if(is_numeric($user)) {
        $field = 'id';
      } else {
        $field = 'username';
      }

      $_data = $this->_db->get('users', array($field, '=', $user));
      if($_data->count()) {
        $this->_data = $_data->results();
        return true;
      }
    }
    return false;
  }

  /*
    @param $username: String of a username to search for in the database.
    @param $password: (String) Password as plain text.
    @action: Searches the database for a username, if found checks if the users
      password_digest is equal to the md5 of the $password variable and the salt of the found user.
    @return: returns true if user is found and password_digest mathches md5, false otherwise.
  */
  public function login($username = null, $password = null ) {
    $user = $this->find($username);
    if($user) {
      if($this->data()['password_digest'] === Hash::make($password, $this->data()['salt'])) {

        Session::put($this->_sessionName, $this->data()['id']);

        return true;
      } else {

        return false;
      }
    }


    return false;
  }


  /*
  @action: Update user information.
  @param id: Id of the user who's information should be updated.
  @param $fields: Associative array of the field  we want to update with the new value. e.g array(
                                                                                                'username' => 'John',
                                                                                                'email' => 'John@example.com'
                                                                                              )
  */
  public function update($id, $fields) {
    if(!$this->_db->update("`c9`.`users`", $id, $fields)) {
      throw new Exception('There was a problem updating user account');
    }
  }

  //Returns the $_data variable.
  public function data() {
    return $this->_data[0];
  }


  /*
  @action: Logs out a user.
  */
    public function logout() {
      Session::delete($this->_sessionName); //Delete session variable containg user info.
      $this->_isLoggedIn = false;
    }

    //Returns the $_isloggedIn variable.
    public function isLoggedIn() {
      return $this->_isLoggedIn;
    }



}
?>
