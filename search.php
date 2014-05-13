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
		<link rel="stylesheet" href="css/style_search.css" type ="text/css" />
		<title>MEGACINE</title>
	</head>
	<body onload="document.getElementById('query').focus();">
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1>Rechercher un film</h1>
			<?php 
				if(!isset($_POST['query'])){
			?>
			<form method="POST" action="#">
				<p>Entrez un mot clé dans notre moteur de recherche (2 à 40 caractères) : </p>
				<input type="text" name="query" id="query" placeholder="Recherche..." minlength="2" maxlength="40" required />
				<input type="submit" value="Rechercher"/>
			</form>
			<?php
				}
				else{
					// Si l'utilisateur a envoyé des données on délègue le traitement de la rechercher à la page incluse ci-dessous
					include('librairies/templates/template_search.php');
				}
			?>
		</div>
		
		
	</body>
</html>