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
		<title>Révise tes maths</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1>Tu es maintenant connecté(e) <?php echo $_SESSION['prenom'].' '. $_SESSION['nom']?> alias <?php echo $_SESSION['pseudo']?> !</h1>
			<p>Cette page "area" sera l'espace principal du site non ?</p>
		</div>
	</body>
</html>