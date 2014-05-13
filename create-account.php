<?php
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();
	
	// Si le visiteur est connecté on le redirige vers l'accueil : il ne faut pas qu'il s'inscrive
	if(isset($_SESSION['estConnecte'])){
		header('Location: area.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MEGACINE</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<link rel="stylesheet" href="css/style_create-account.css" type="text/css" />
	</head>
	<body onload="document.getElementById('pseudo').focus();">
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<div id="quote">
				<p id="sentence">Inscrivez-vous pour vivre le cinéma au plus près.</p>
			</div>
			<div id="register_box">
				<h1>Créer un compte<h1>
				<form method="POST" action="register.php" id="form_register">
					<input type="text" name="pseudo" placeholder="Pseudo" maxlength="20" id="pseudo" required /><br />
					<input type="password" name="password" placeholder="Mot de passe" maxlength="20" id="password" required /><br />
					<input type="text" name="prenom" placeholder="Prénom" maxlength="35" id="prenom" required /><br />
					<input type="text" name="nom" placeholder="Nom" maxlength="35" id="nom" required /><br />
					<input type="email" name="mail" placeholder="E-Mail" maxlength="35" id="mail" required /><br />
					<input type="submit" value="Inscription" id="submit"/><br />
				</form>
			</div>
		</div>
	</body>
</html>