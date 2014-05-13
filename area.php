<?php
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();
	require_once('includes/auto_login.php');
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type ="text/css" />
		<title>MEGACINE</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1><?php echo $_SESSION['prenom'].' '. $_SESSION['nom']?></h1>
			<p>Cherchez un film dans notre base de données:</p>
		</div>
	</body>
</html>