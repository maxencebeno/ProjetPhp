<?php
	require_once('../../../includes/db_connect.php');
	$bdd = connect_db();

	// on sécurise la variable $_GET
	$chgt = htmlspecialchars($_GET['chgt']);

	if($chgt == "ajout_film") {
		if(isset($_POST['titre_film']) AND isset($_POST['annee_film']) AND isset($_POST['score_film'])) {
			$titre = htmlspecialchars($_POST['titre_film']);
			$annee = htmlspecialchars($_POST['annee_film']);
			$score = htmlspecialchars($_POST['score_film']);

			$req = $bdd->prepare('INSERT INTO Movie (Titre, Année, Score, Votes) VALUES (?, ?, ?, 0)');
			$req->execute(array($titre, $annee, $score));
			$req->closeCursor();

			header('Location: ../../index.php');
		}
	} else if ($chgt == "suppression_film") {
		$id_film = htmlspecialchars($_GET['id']);

		$req = $bdd->prepare('DELETE FROM Movie WHERE MovieID = ?');
		$req->execute(array($id_film));
		$req->closeCursor();


		$req = $bdd->prepare('SELECT * FROM Casting WHERE MovieID = ?');
		$req->execute(array($id_film));

		while($donnees = $req->fetch()) {
			$req = $bdd->prepare('DELETE FROM Casting WHERE MovieID = ?');
			$req->execute(array($id_film));
		}

		$req->closeCursor();
		$req->closeCursor();

		header("Location: ../../index.php");
	} else {
		header("Location: ../../index.php");
	}
	header("Location: ../../index.php");
?>


