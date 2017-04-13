<?php //include config

$blog = $model['blog'];
$user = $model['user'];
//if not logged in redirect to login page
//if(!$user->isLoggedIn()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Post</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php //include('menu.php');?>
  <h1>Blog</h1>
  <ul id='adminmenu'>
  	<li><a href='../admin'>Blog</a></li>
  	<li><a href='../admin/users'>Users</a></li>
  	<li><a href="../" target="_blank">View Website</a></li>
  	<li><a href='logout.php'>Logout</a></li>
  </ul>
  <div class='clear'></div>
  <hr />


	<p><a href="./">Blog Admin Index</a></p>

	<h2>Edit Post</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

    //Check if get or post variables exists
  	if(Input::exists()) {

      //basic validation
      $validate = new Validate();
      $validation = $validate->check(array(
        'id' => array(
          'required' => true
        ),
        'postTitle' => array(
            'required' => true
        ),
        'postDesc' => array(
            'required' => true
        ),
        'postCont' => array(
            'required' => true
        )
      ));


      if(!isset($error)){ //If there are no validation errors

        try {

          //insert into database
          $blog->update(Input::get('id'), array(    //stores new user data in database. See User->create() function.
              'author' => $user->data()['username'],
              'postTitle' => Input::get('postTitle'),
              'postDesc' => Input::get('postDesc'),
              'postCont' => Input::get('postCont')
            ));

          //redirect to index page
          header('Location: index.php?action=updated');
          exit;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

      }
    }

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />'; //output errors
		}
	}

  try {

    //Search for blog with specified id
    $blog->find(str_replace('_', ' ', $data['postTitle']));

  } catch(PDOException $e) {
      echo $e->getMessage();
  }

	?>

	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $blog->data()['id'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php echo $blog->data()['postTitle'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php echo $blog->data()['postDesc'];?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php echo $blog->data()['postCont'];?></textarea></p>

		<p><input type='submit' name='submit' value='Update'></p>

	</form>

</div>

</body>
