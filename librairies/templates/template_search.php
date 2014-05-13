<?php

$query = htmlspecialchars($_GET['q']);
if(strlen($query) >= 1 AND strlen($query) <= 40){
	$resultat_vide = true;
	echo '<h1>Résultats pour "'.$query.'"</h1>';

	// On analyse la requête: si elle comporte plusieurs mots, elle nécessite un traitement pour séparer les mots afin d'avoir une recherche plus précise !
	$tableau_mots_cles = explode(' ' , $query);
	$nb_elem=count($tableau_mots_cles); 

	// On va incrémenter une requête sous forme de chaine de cractère pour incrémenter avec tous les mots clés
	$requete = 'SELECT * FROM Movie WHERE Titre LIKE "%'.$tableau_mots_cles[0].'%" ';
	for($i=1 ; $i<$nb_elem; $i++) { 
		$requete.='OR (Titre LIKE "%'.$tableau_mots_cles[$i].'%")';
	} 
	$requete .= 'ORDER BY Titre';
	
	// On envoie la chaîne de caractères $requete à query
	$req = $bdd->query($requete);

	// On affiche tous les films trouvés enfin !
	while($donnees = $req->fetch()){
		echo '<div class="search_films">
		<p><span class="title_film">Titre</span>: '.$donnees['Titre'].'<br />
		<span class="title_film">Année</span>: '.$donnees['Année'].'<br />
		<span class="title_film">Score</span>: '.$donnees['Score'].'<br />
		<span class="title_film">Vote</span>: '.$donnees['Votes'].'<br />
		<span class="details_button"><a href="details.php?id='.$donnees['MovieID'].'">Détails sur le film</a></span></p>
		</div>';
		$resultat_vide = false; // On passe la variable à false pour ne pas afficher de message d'erreur car on a des résultats !
	}
	
	if($resultat_vide){
		echo '<p id="no_result">Votre recherche n\'a donné aucun résultat. Veuillez <a href="search.php">réessayer</a>.</p>';
	}
}
else{
	echo '<p id="no_result">Erreur: Votre requête doit comporter entre 2 et 40 caractères. Veuillez <a href="search.php">réessayer</a></p>';
}