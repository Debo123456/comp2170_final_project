<?php

$user = $model['user'];
$blog = $model['blog'];

//if not logged in redirect to login page
//if(!$user->isLoggedIn()){ header('Location: login.php'); }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="/mvc_example2/public/style/normalize.css">
    <link rel="stylesheet" type="text/css" href="/mvc_example2/public/style/main.css">
    <script language="JavaScript" type="text/javascript">
      function deluser(id, title)
      {
        if (confirm("Are you sure you want to delete '" + title + "'"))
        {
          window.location.href = 'users.php?deluser=' + id;
        }
      }
    </script>
</head>
<body>

	<div id="wrapper">

	<?php //include('/wamp/www/mvc_example2/app/views/includes/menu.php');?>
  <h1>Blog</h1>
  <ul id='adminmenu'>
  	<li><a href='../admin'>Blog</a></li>
  	<li><a href=''>Users</a></li>
  	<li><a href="../" target="_blank">View Website</a></li>
  	<li><a href='logout.php'>Logout</a></li>
  </ul>
  <div class='clear'></div>
  <hr />


	<?php
	//show message from add / edit page
	if(isset($_GET['action'])){
		echo '<h3>User '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Username</th>
		<th>Email</th>
		<th>Action</th>
	</tr>
	<?php
			$results = $blog->get('blog_members'); //Retreive all users info from database.
      //Print users info retreive from database.

			foreach($results as $row){

				echo '<tr>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				?>

				<td>
					<a href="edit-user.php?id=<?php echo $row['id']; //print edit link?>">Edit</a>
					<?php if($row['id'] != 1){  //Prevent the deletion of user with id number of 1. (Admin).?>
						| <a href="javascript:deluser('<?php echo $row['id'];?>','<?php echo $row['username']; //print delete link?>')">Delete</a> .
					<?php } ?>
				</td>

				<?php
				echo '</tr>';

			}


	?>
	</table>

	<p><a href='add_user'>Add User</a></p>

</div>

</body>
