<?php
	require_once('../../../includes/db_connect.php');
	$bdd = connect_db();
	
	$id_film = htmlspecialchars($_GET['id']);
	$chgt = htmlspecialchars($_GET['chgt']);

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
	} else {
		if($chgt == "info") {
			if(isset($_POST['annee']) AND !empty($_POST['annee'])) {
				$annee = htmlspecialchars($_POST['annee']);
				$req = $bdd->prepare("UPDATE Movie SET Année = :annee WHERE MovieID = :id_film");
				$req->execute(array(
						'annee' => $annee,
						'id_film' => $id_film
					));
				$req->closeCursor();
				header('Location: ../../modify.php?id='.$id_film.'');
			}
			if(isset($_POST['score']) AND !empty($_POST['score'])) {
				$score = htmlspecialchars($_POST['score']);
				echo $score;
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
					
			}
	 else {
		$message = "Erreur : vous faites n'importe quoi";
					header('Location: ../../modify.php?id='.$id_film.'&amp;message='.$message.'');
	}
}

?>