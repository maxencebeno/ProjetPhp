<?php

	function inserer_classement($score, $id_user, $bdd, $niveau) {

		$req = $bdd->prepare("SELECT * FROM Classement WHERE id_user = ?"); 
		$req->execute(array($id_user));
		
		$resultat = $req->fetch();
		if($resultat['best_score_user'] < $score) {
			$req = $bdd->prepare("UPDATE Classement SET best_score_user = :score");
			$req->execute(array(
				'score' => $score
			));
			header('Location: area.php');
		}
		else {
			header('Location: area.php');
		}
		$req->closeCursor();
	}
		
?> 