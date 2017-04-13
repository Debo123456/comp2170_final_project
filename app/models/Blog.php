<?php
  class Blog {
    private $_db, $_data;


    public function __construct() {
      $this->_db = DB::getInstance();  //gets an instance of our database pdo object
    }


    /*
      @param $fields: Associative array of fields and values to be added to the blog_posts table
      @action: Creates a blog post entry into our database
    */
    public function create($fields = array()) {
      /*if(!$this->_db->insert("`blog`.`blog_posts`", $fields)) {
        throw new Exception('There was a problem creating the post.'); //Throws an exception if query fails.
      }*/
    }

    /*
      @action: Checks if a specific blog post exists
      @param $id: Blog post id to query
      @returns: True if a blog post was found with the specific id and false otherwise
    */
    public function exists($id) {
      /*$check = $this->_db->get('blog_posts', array('id', '=', $id));
      if($check->count()) {
        return true;
      }
      return false;*/
    }


    /*
      @action: Finds a blog pog post and stores its values inthe $_data variable
      @param $blog: The post id we want to query
      @returns: Returns true if the blog_post was found and false otherwise
    */
    public function find($postTitle = null) {
      /*if($postTitle) {
        $_data = $this->_db->get('blog_posts', array('postTitle', '=', $postTitle)); //Fetch data base with the id we passed as parameter and stores it in $_data variable.

        if($_data->count()) {
          $this->_data = $_data->results();  //Assigns the associative array of the results to the $_data variable
          return true;
        }
      }
      return false;*/
    }


    /*
      @action: Queries the atabase for bog posts that match a certain criteria, if no criteria specified then all posts returned.
      @perform a select query on our database
      @param $table: The database table we want to query.
      @param $where: array containing the where condition for our query. e.g array('id', '=', '5').
      @returns returns nested associative array containing the post values from the query.
    */
    public function get($table, $where = array()) {
      /*if(count($where)) {
        $this->_data = $this->_db->get($table, $where); //Runs query including where condition
      }
      else {
        $this->_data = $this->_db->get($table); //Runs query to return all posts.
      }

      $this->_data = $this->_data->results();  //Stores associative array of query reslts in the $_data variable.
      return $this->data();*/
    }


    /*
      @action: Updates a blog post.
      @param $id: The id of the post we want to update.
      @param $fields: Associative array of the field  we want to update with the new value. e.g array(
                                                                                                  'description' => 'This a new description',
                                                                                                  'Title' => 'This is a new Title'
                                                                                                )
    */
    public function update($id, $fields) {
      /*if(!$this->_db->update("`blog`.`blog_posts`", $id, $fields)) {
        throw new Exception('There was a problem updating blog post');  //Throws exception if the query has errors.
      }*/
    }

    /*
    @action: Delete a postTitle
    @param $id: id of the post we want to delete.
    */
    public function delete($id) {
      /*if(!$this->_db->delete($id, '`blog_posts`')) { //If query was executed succesfully.
        throw new Exception('There was a problem deleting the post.'); //Throws exception if query has errors.
      }*/
    }

    /*
      @action: Returns the $_data variable. $_data will have a nested array of query results, If there is only one result,
      the first element of the nested array is returned, if there are multiple results the full nested array is returned.
    */
    public function data() {
      /*if(count($this->_data) == 1) {
        return $this->_data[0];
      } else {
        return $this->_data;
      }*/
    }
  }
?>
