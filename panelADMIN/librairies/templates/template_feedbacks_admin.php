<?php
	require_once('../../../includes/db_connect.php');
	$bdd = connect_db();

	$id_feedback = $_GET['id_feedback'];

	if(isset($_POST['envoi_traite']) AND isset($_POST['traite'])) {			
		$done = true;

		$req = $bdd->prepare("UPDATE Feedbacks SET done = ? WHERE id_feedback = ?");
		$req->execute(array($done, $id_feedback));

		$req->closeCursor();
		header("Location: ../../feedbacks_admin.php");
	}
	else {
		echo "Erreur : il faut remplir les champs";
	}
?>