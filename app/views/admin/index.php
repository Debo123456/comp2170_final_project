<?php
//include config
$user = $model['user'];
$blog = $model['blog'];


//if not logged in redirect to login page
if(!$user->isLoggedIn()){ header('Location: /mvc_example2/public/login'); }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="/mvc_example2/public/style/normalize.css">
    <link rel="stylesheet" type="text/css" href="/mvc_example2/public/style/main.css">
		<script language="JavaScript" type="text/javascript">
		  function delpost(id, title)
		  {
		    if (confirm("Are you sure you want to delete '" + title + "'"))
		    {
		      window.location.href = 'admin/delpost/' + id;
		    }
		  }
		</script>
</head>
<body>

	<div id="wrapper">

	<?php //include('/wamp/www/mvc_example2/app/views/includes/menu.php');?>
  <h1>Blog</h1>
  <ul id='adminmenu'>
  	<li><a href='admin'>Blog</a></li>
  	<li><a href='admin/users'>Users</a></li>
  	<li><a href="../" target="_blank">View Website</a></li>
  	<li><a href='admin/logout'>Logout</a></li>
  </ul>
  <div class='clear'></div>
  <hr />


	<?php
	//show message from add / edit page
	if(isset($_GET['action'])){
		echo '<h3>Post '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$results = $blog->get('blog_posts'); //Get blog info

			//Print contents of first 10 blog posts.
			foreach($results as $row){

				echo '<tr>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<a href="admin/edit_post/<?php echo str_replace(' ', '_', $row['postTitle'])?>">Edit</a> |
					<a href="javascript:delpost('<?php echo $row['id'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
				</td>

				<?php
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='admin/add_post'>Add Post</a></p>

</div>

</body>
