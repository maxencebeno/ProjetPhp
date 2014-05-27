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
			$done = false;

			$req = $bdd->prepare("INSERT INTO Feedbacks (id_user, nom_user, prenom_user, message, done) VALUES (?, ?, ?, ?, ?)");
			$req->execute(array($id_user, $nom, $prenom, $message, $done));

			$req->closeCursor();
			header("Location: ../../feedbacks.php");
		}
		else {
			header("Location: ../../feedbacks.php"); // Message trop court on redirige
		}
	}
	else {
		echo "Erreur : il faut remplir les champs";
	}
?>