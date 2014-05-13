<?php
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();
	require_once('includes/auto_login.php');
	
	// Si le visiteur est connecté on le redirige vers son espace perso, inutile de lui montrer la page d'accueil
	if(isset($_SESSION['estConnecte'])){
		header('Location: area.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MEGACINE</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="UTF-8">
	</head>
	<body onload="document.getElementById('pseudo_login').focus();">
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1>MEGACINE</h1>
			<article>
				<p>Bienvenue sur le concurrent d'Allociné. Trouver un film, lisez sa critique et donnez-nous votre avis !</p>
				<p id="p_account"><a href="create-account.php"><button>Commencer</button></a></p>
			<article>
		</div>
	</body>
</html>