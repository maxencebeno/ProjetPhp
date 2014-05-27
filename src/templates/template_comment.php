<?php
	session_start();
	require_once('../../includes/db_connect.php');
	$bdd = connect_db();
	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
	$id_user = $_SESSION['id_user'];
	$id_film = htmlspecialchars($_GET['id']);
	$message = htmlspecialchars($_POST['message']);

	if(isset($_POST['message'])) {

		if(strlen($_POST['message'] < 2)) {

			$req = $bdd->prepare("INSERT INTO Comment (id_user, nom_user, prenom_user, message, MovieID) VALUES (?, ?, ?, ?, ?)");
			$req->execute(array($id_user, $nom, $prenom, $message, $id_film));

			$req->closeCursor();
			header("Location: ../../details.php?id=".$_GET['id']."#submit_comment");
		}
		else {
			header("Location: ../../details.php?id=".$_GET['id'].""); // Message trop court on redirige
		}
	}
	else {
		echo "Erreur : il faut remplir les champs";
	}
?>