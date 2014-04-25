<?php

	function inserer_score($score, $id_user, $bdd) {

		$req = $bdd->prepare("SELECT * FROM Scores WHERE id_user = ?"); 
		$req->execute(array($id_user));
		
		$resultat = $req->fetch();
		$date = date("Y-m-d");
		$req = $bdd->prepare("INSERT INTO Scores (id_score, id_user, pseudo_user, mail_user, nom_user, prenom_user, date_score, score_user) VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
		$req->execute(array($id_user, $_SESSION["pseudo"], $_SESSION["mail"], $_SESSION["nom"], $_SESSION["prenom"], $date, $score));

		$req->closeCursor();	}
		
?> 