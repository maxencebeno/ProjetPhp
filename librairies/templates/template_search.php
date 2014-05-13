<?php
$query = htmlspecialchars($_GET['q']);
$query = trim($query, " \t.");
echo '<h1>Recherche de films</h1>';
echo '<form method="GET" action="search.php" id="form_query2">
		<input type="text" name="q" id="query2" minlength="2" maxlength="40" autocomplete="off" value="'.$query.'"/>
		<input type="submit" value="Rechercher" id="submit2"/>
	 </form>';
if(strlen($query) > 0){
	$resultat_vide = true;
	// On analyse la requête: si elle comporte plusieurs mots, elle nécessite un traitement pour séparer les mots afin d'avoir une recherche plus précise !
	$query=preg_replace('/\s\s+/', ' ', $query); 
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
		echo '<div id="no_result">
		<p>Aucun document ne correspond aux termes de recherche spécifiés (<strong>'.$query.'</strong>).<br /><br />
		Suggestions :</p>
		<ul>
			<li>Le film que vous cherchez n\'existe pas dans notre base de données.</li>
			<li>Vérifiez l’orthographe des termes de recherche.</li>
			<li>Essayez d\'autres mots.</li>
			<li>Utilisez des mots clés plus généraux.</li>
		</ul>
		</div>';
	}
}else{
	echo '<p id="empty_query">Votre recherche semble être vide...</p>';
}