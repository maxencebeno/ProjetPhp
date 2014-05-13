<?php

$query = htmlspecialchars($_GET['q']);
if(strlen($query) >= 2 AND strlen($query) <= 40){
	$resultat_vide = true;
	$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre LIKE "%'.$query.'%" ORDER BY Titre ');
	$req->execute(array($query));
	echo '<h1>Résultats pour "'.$query.'"</h1>';
	while($donnees = $req->fetch()){
		echo '<div class="search_films">
		<p><span class="title_film">Titre</span>: '.$donnees['Titre'].'<br />
		<span class="title_film">Année</span>: '.$donnees['Année'].'<br />
		<span class="title_film">Score</span>: '.$donnees['Score'].'<br />
		<span class="title_film">Vote</span>: '.$donnees['Votes'].'<br />
		<span class="details_button"><a href="details.php?id='.$donnees['MovieID'].'">Détails sur le film</a></span></p>
		</div>';
		$resultat_vide = false;
	}

	if($resultat_vide){
		echo '<p id="no_result">Votre recherche n\'a donné aucun résultat. Veuillez <a href="search.php">réessayer</a>.</p>';
	}
}
else{
	echo '<p id="no_result">Erreur: Votre requête doit comporter entre 2 et 40 caractères. Veuillez <a href="search.php">réessayer</a></p>';
}