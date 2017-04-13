<?php
class DB {
  private static $_instance =  null;
  private $_pdo, $_query, $_error = false, $_results, $_count=0;

  /*Constructor creates a pdo object with the database credentials we have defined in init.php*/
  private function __construct() {

    try{
      $this->_pdo = new PDO('mysql:host='. Config::get('mysql/host') .';dbname='. Config::get('mysql/db'),Config::get('mysql/username'), Config::get('mysql/password'));
      $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    //Catch exception if database connection failed.
    catch(PDOExecption $e){
      echo 'Something was wrong with the connection';
      die($e->getMessage());
    }
  }

  /*Returns a variable containing the pdo object created by the constructor */
  public static function getInstance() {
    if(!isset(self::$_instance)) {
      self::$_instance = new DB();
    }
    return self::$_instance;
  }

  /*
  @param $sql: String containing an sql statement before value(s) have been binded to it.
  @param $params: Array() of values to be binded to sql statement.
  @action: Executes a query on the database.
  @return: If succesful returns an array of the values found in the database else sets the variable $_error to true.
  */
  public function query($sql, $params = array()) {
    $this->_error = false;
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if (count($params)) {
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }


      if($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll();
        $this->_count = $this->_query->rowCount();
      }
      else {
        $this->_error = true;
      }
    }

    return $this;
  }

  /*
  @param $action: (String) The action we wish to perform on the database table e.g. 'SELECT *' or 'DELETE'.
  @param $table: (String) database table we want to SELECT FROM
  @param $where: (array[3]) array contaning the WHERE conditions, contains
    table collumn we want to compare, the operator of the operation and the value we want to compare to.
    e.g. array('username', '=', 'John'). If no $where parameter is passed, SELECTS all(*) FROM the database.
  @return: If successful an array of database values found else returns false.
  */
  public function action($action, $table, $where = array()) {
    if(count($where)) {
      if(count($where) === 3) {
        $operators = array('=', '>', '<', '>=', '<=');

        $field = $where[0];
        $operator = $where[1];
        $value = $where[2];

        if(in_array($operator, $operators))
        {
          $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
          if (!$this->query($sql, array($value))->error()) {
            return $this;
          }
          else {
            return false;
          }
        }
      }
    }
    else {
				$sql = "{$action} FROM {$table}";
				if (!$this->query($sql)->error()) {
					return $this;
				}
				else {
					return false;
				}
			}
  }

  /*
    @param $table: (String) database table we want to SELECT FROM
    @param $where: (array[3]) array contaning the WHERE conditions, contains
      table collumn we want to compare, the operator of the operation and the value we want to compare to.
      e.g. array('username', '=', 'John'). If no $where parameter is passed, SELECTS all(*) FROM the database.
    @return: If successful an array of database values found else returns false.
  */
  public function get($table, $where = array()) {
			if(count($where)) {
				return $this->action('SELECT *', $table, $where);
			}
			else {
				return $this->action('SELECT *', $table);
			}
		}


  public function insert($table, $fields = array()) {
    if(count($fields)) {
      $keys = array_keys($fields);
      $values = '';
      $x = 1;

      foreach ($fields as $field) {
        $values .= "'" . $field . "'";

        if($x < count($fields)) {
          $values .= ', ';
        }
        $x++;
      }

      $sql = "INSERT INTO {$table} (`". implode('`, `', $keys) ."`) VALUES ({$values})";
      

      if(!$this->query($sql, $fields)->error()) {
        return true;
      }
    }
    return false;
  }

  public function update($table, $id, $fields) {
    $set = '';
    $x = 1;

    foreach ($fields as $name => $value) {
      $set .= "{$name} = ?";
      if($x < count($fields)) {
        $set .= ', ';
      }
      $x++;
    }

    $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

    if(!$this->query($sql, $fields)->error()) {
      return true;
    }

    return false;
  }

  /*
  @action: Deletes a blog post.
  @Param $id: The id of the entry we want delete.
  @param $table: Table that contains the entry we want to delete.
  @return: Return true if entry was deleted succesfully.
  */
  public function delete($id, $table) {
    $stmt = $this->_pdo->prepare("DELETE FROM {$table} WHERE `id`={$id}") ; //prepare sql statement
    return($stmt->execute());  //execute sql statement;
  }


  //Return $_results variable.
  public function results() {
    return $this->_results;
  }

  //Returns the $_error variable.
  public function error() {
    return $this->_error;
  }

  //Returns the $_count variable.
  public function count() {
    return $this->_count;
  }
}

?>
