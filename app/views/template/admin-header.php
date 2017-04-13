<?php
//include config
$user = $model['user'];
$blog = $model['blog'];


//if not logged in redirect to login page
if(!$user->isLoggedIn()){ header('Location: /mvc_example2/public/login'); }
if(isset($_GET['delpost'])){
	try {
		$blog->delete($_GET['delpost']); //delete post with the same id as the $_GET['delpost'] variable.
	} catch(Exception $e) {
		die($e->getMessage());
	}

	header('Location: /mvc_example2/public/admin'); //Redirect to index page.
	exit;
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" type="text/css" href="/mvc_example2/public/style/normalize.css">
  <link rel="stylesheet" type="text/css" href="/mvc_example2/public/style/main.css">
</head>
