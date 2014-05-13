<?php 
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();	
	require_once('includes/auto_login.php');
	require('librairies/templates/insert.php');
	require('librairies/templates/template_classement.php');
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type ="text/css" />
		<link rel="stylesheet" href="css/style_play.css" type ="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<title>MEGACINE</title>
	</head>
	<body onload="document.getElementById('answer').focus();">
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1>Rechercher un film</h1>
		</div>
		
		
	</body>
</html>