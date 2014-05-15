<?php
	session_start(); 
	require("includes/db_connect.php");
	$bdd = connect_db();
	
	//-----------------------------------------------------------------------------------------------------------------------------
	// Vérification des informations et connection
	//-----------------------------------------------------------------------------------------------------------------------------
		
		// Si les champs sont remplis
		if(isset($_POST["pseudo"]) AND isset($_POST["password"])) {
			$req = $bdd->prepare("SELECT * FROM user WHERE pseudo_user = ? AND pass_user = ?");
			$req->execute(array($_POST['pseudo'], sha1($_POST['password'])));
			
			// Si un utilisateur correspond au pseudo + mot de passe on le connecte, sinon on ne fait rien et l'utilisateur verra cette page avec le formulaire
			if($donnees = $req->fetch()){
				$_SESSION['id_user'] = htmlspecialchars($donnees['id_user']);
				$_SESSION['nom'] = htmlspecialchars($donnees['nom_user']);
				$_SESSION['pseudo'] = htmlspecialchars($donnees['pseudo_user']);
				$_SESSION['prenom'] = htmlspecialchars($donnees['prenom_user']);
				$_SESSION['mail'] = htmlspecialchars($donnees['mail_user']);
				$_SESSION['date_inscription'] = htmlspecialchars($donnees['date_inscription']);
				$_SESSION['estConnecte'] = true;

				// Se souvenir de moi
				if($_POST['auto_login']){
					//-------------------------------------------------------------------------------------------------
					//Création de la variable datr qui sera la log_key dans la base de données et datr dans les cookies
					include('librairies/templates/generer.php');
					$datr = generer(30);
					//-------------------------------------------------------------------------------------------------
					
					setcookie('pseudo', $_SESSION['pseudo'], time() + 24*3600, '/', null, false, true);
					setcookie('datr', $datr, time() + 24*3600, '/', null, false, true);
					
					//Puis en dessous on inscrit la log_key dans la base de donnée avec un update
					$req = $bdd->prepare('UPDATE user SET log_key = :log_key WHERE id_user = :id_user');
					$req->execute(array(
									'log_key' => $datr,
									'id_user' => $_SESSION['id_user']
					));
				}

				// Redirection
				header("Location: area.php");
			}
		}
		else{
			$_SESSION['estConnecte'] = false;
			header('Location: index.php');
		}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Erreur de connexion</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<link rel="stylesheet" href="css/style_login.css" type="text/css" />
	</head>
	
	<body onload="document.getElementById('pseudo').focus();">
		<header>
			<nav id="menu">
				<ul>
					<li><a href="index.php">Accueil</a></li>
				</ul>
			</nav>
		</header>
		
		<div id="wrapper">
			<p id="p_erreur">Vous vous êtes trompé de pseudo ou de mot de passe. Essayez à nouveau !</p>
		
			<h1>Se connecter</h1>
			<form method="POST" action="#" id="form_login2">
				<input type="text" name="pseudo" placeholder="Pseudo" maxlength="20" id="pseudo" required /><br />
				<input type="password" name="password" placeholder="Mot de passe" maxlength="20" id="password" required /><br />
				<input type="checkbox" name="auto_login" id="auto_login" checked="checked" />
				<label for="auto_login" id="label_auto_login">Se souvenir de moi</label><br >
				<input type="submit" value="Se connecter" id="submit"/>
			</form>

		</div>
	</body>
</html>