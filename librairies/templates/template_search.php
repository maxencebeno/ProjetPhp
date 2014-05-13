<?php

$query = htmlspecialchars($_POST['query']);
if(strlen($_POST['query']) >= 2 AND strlen($_POST['query']) <= 40){
	$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre LIKE "%'.$query.'%" ORDER BY Titre ');
	$req->execute(array($query));
	while($donnees = $req->fetch()){
		echo '<div class="search_films">
		<p><span class="title_film">Titre</span>: '.$donnees['Titre'].'<br />
		<span class="title_film">Année</span>: '.$donnees['Année'].'<br />
		<span class="title_film">Score</span>: '.$donnees['Score'].'<br />
		<span class="title_film">Vote</span>: '.$donnees['Votes'].'<br />
		<a href="details.php?id='.$donnees['MovieID'].'">Détails sur le film</a></p>
		</div>';
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