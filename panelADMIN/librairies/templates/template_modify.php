<?php
	require_once('../../../includes/db_connect.php');
	$bdd = connect_db();
	

	// on sécurise la variable $_GET
	$id_film = htmlspecialchars($_GET['id']);
	$chgt = htmlspecialchars($_GET['chgt']);


	// Si on décide de changer le titre
	if($chgt == "titre") {
		if(isset($_POST['titre'])) {
			$titre = htmlspecialchars($_POST['titre']);

			$req = $bdd->prepare("UPDATE Movie SET Titre = :titre WHERE MovieID = :id_film");
			$req->execute(array(
					'titre' => $titre,
					'id_film' => $id_film
				));
			$req->closeCursor();

			header('Location: ../../modify.php?id='.$id_film.'');
		} else {
			header('Location: ../../modify.php?id='.$id_film.'');
		}

	} else if($chgt == "info") { // Si le changement porte sur les infos
		if(isset($_POST['annee']) AND !empty($_POST['annee'])) { // on donne la possibilité à l'utilisateur de ne pas forcémement modifier tous les champs
			$annee = htmlspecialchars($_POST['annee']);

			$req = $bdd->prepare("UPDATE Movie SET Année = :annee WHERE MovieID = :id_film"); //On met à jour la table demandée
			$req->execute(array(
				'annee' => $annee,
				'id_film' => $id_film
				));
			$req->closeCursor();

			header('Location: ../../modify.php?id='.$id_film.''); // on redirige vers la page détail du film
		}
		if(isset($_POST['score']) AND !empty($_POST['score'])) {
			$score = htmlspecialchars($_POST['score']);

			$req = $bdd->prepare("UPDATE Movie SET Score = :score WHERE MovieID = :id_film");
			$req->execute(array(
				'score' => $score,
				'id_film' => $id_film
				));
			$req->closeCursor();

			header('Location: ../../modify.php?id='.$id_film.'');
		}
		if(isset($_POST['votes']) AND !empty($_POST['votes'])) {
			$votes = htmlspecialchars($_POST['votes']);

			$req = $bdd->prepare("UPDATE Movie SET Votes = :votes WHERE MovieID = :id_film");
			$req->execute(array(
				'votes' => $votes,
				'id_film' => $id_film
				));
			$req->closeCursor();

			header('Location: ../../modify.php?id='.$id_film.'');
		}

	} else if($chgt == "acteur") {
	 	$id_acteur = htmlspecialchars($_GET['id_acteur']);

	 	if(isset($_POST['ordinal']) AND !empty($_POST['ordinal'])) {
	 		$ordinal = htmlspecialchars($_POST['ordinal']);

	 		$req = $bdd->prepare("UPDATE Casting SET Ordinal = :ordinal WHERE MovieID = :id_film AND ActorId = :id_acteur");
			$req->execute(array(
				'ordinal' => $ordinal,
				'id_film' => $id_film,
				'id_acteur' => $id_acteur
				));
			$req->closeCursor();

			header('Location: ../../modify.php?id='.$id_film.'');
	 	}
	 	if(isset($_POST['nom']) AND !empty($_POST['nom'])) {
	 		$nom = htmlspecialchars($_POST['nom']);

	 		$req = $bdd->prepare("UPDATE Actor SET Nom = :nom WHERE ActorId = :id_acteur");
			$req->execute(array(
				'nom' => $nom,
				'id_acteur' => $id_acteur
				));
			$req->closeCursor();

			header('Location: ../../modify.php?id='.$id_film.'');
	 	}
	 } else if($chgt == "suppression") {
	 	$id_acteur = htmlspecialchars($_GET['id_acteur']);

	 	$req = $bdd->prepare('DELETE FROM Actor WHERE ActorId = ?');
	 	$req->execute(array($id_acteur));
	 	$req->closeCursor();

		header('Location: ../../modify.php?id='.$id_film.'');
	 } else if($chgt == "ajout") {
	 	if(isset($_POST['ordinal_acteur']) AND isset($_POST['nom_acteur'])) {
	 		$ordinal_acteur = htmlspecialchars($_POST['ordinal_acteur']);
	 		$nom_acteur = htmlspecialchars($_POST['nom_acteur']);

	 		$req = $bdd->prepare('INSERT INTO Actor (Nom) VALUES (?)');
	 		$req->execute(array($nom_acteur));
	 		$req->closeCursor();

	 		$req = $bdd->prepare('SELECT * FROM Actor WHERE Nom = ?');
	 		$req->execute(array($nom_acteur));
	 		$nouvel_acteur = $req->fetch();
	 		$nouvel_id_acteur = htmlspecialchars($nouvel_acteur['ActorId']);
	 		$req->closeCursor();

	 		$req = $bdd->prepare('INSERT INTO Casting (MovieID, ActorId, Ordinal) VALUES (?, ?, ?)');
	 		$req->execute(array($id_film, $nouvel_id_acteur, $ordinal_acteur));
	 		$req->closeCursor();

	 		header('Location: ../../modify.php?id='.$id_film.'');
	 	}
	 } else {
	 	header('Location: ../../modify.php?id='.$id_film.'');
	 }

?>