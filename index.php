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
		<title>Révise tes maths !</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="UTF-8">
	</head>
	<body onload="document.getElementById('pseudo_login').focus();">
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1>Révise tes maths !</h1>
			<article>
				<p>Marre des mauvaises notes en maths à cause d'erreurs en calculs mentaux? Révise tes maths vient à ton secours!</p>
				<p>Notre site te permet de réviser de façon ludique tes tables de multiplications. Nous proposons de jouer seul ou avec des amis sur une interface simple et facile à comprendre.</p>
				<p>Différents niveaux existent dans Révise tes maths. Du plus simple au plus corsé pour devenir incollable sur les tables de multiplication!</p>
				<p>Notre particularité est l'esprit de compétition pour stimuler les enfants. Un classement est disponible pour te situer par rapport à tes amis.</p>
				<p id="p_account"><a href="create-account.php"><button>Commencer</button></a></p>
			<article>
		</div>
	</body>
</html>