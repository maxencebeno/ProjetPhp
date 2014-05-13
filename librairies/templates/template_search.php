<?php

$query = htmlspecialchars($_POST['query']);
if(strlen($_POST['query']) >= 2 AND strlen($_POST['query']) <= 40){
	$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre LIKE "%'.$query.'%" ORDER BY Titre ');
	$req->execute(array($query));
	while($donnees = $req->fetch()){
		echo '<p><strong>Titre</strong>: '.$donnees['Titre'].'<br />';
		echo '<strong>Année</strong>: '.$donnees['Année'].'<br />';
		echo '<strong>Score</strong>: '.$donnees['Score'].'<br />';
		echo '<strong>Vote</strong>: '.$donnees['Votes'].'<br /></p>';
	}

	if($donnees == NULL){
		echo '<p>Votre recherche n\'a donné aucun résultat. Veuillez réessayer.</p>';
	}

	echo '<p><a href="search.php">Recommencer ma recherche</a></p>';
}
else{
	echo '<p>Erreur: Votre requête doit comporter entre 2 et 40 caractères.</p>';
	echo '<p><a href="search.php">Recommencer ma recherche</a></p>';
}