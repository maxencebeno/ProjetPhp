<?php
 session_start();
 error_reporting(-1); 
 require_once('../../../includes/db_connect.php');
 $bdd = connect_db();

// On récupère le nom du fichier
$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine); // On récupère son extension
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("txt");
if (!(in_array($extensionFichier, $extensionsAutorisees))) { // On vérifie que l'extension est bien celle attendue
    $_SESSION['message']=  "Le fichier n'a pas l'extension attendue";
    header("Location: ../../index.php");
} else {    
    // Copie dans le repertoire du script avec son nom
    $repertoireDestination = "./Ajout_Film/";
    $nomDestination = $nomOrigine;

    move_uploaded_file($_FILES["monfichier"]["tmp_name"], $repertoireDestination.$nomDestination);
}	
	// Tant que le fichier n'est pas fini on le parcours pour récupérer et insérer les acteur ayant participés au film
if($fichier = fopen("Ajout_Film/".$nomOrigine,"r")) {
	$titre = fgets($fichier);
	$annee = fgets($fichier);
	$score = fgets($fichier);
} else {
	$_SESSION['message'] = "Erreur lors de l'ouverture du fichier";
	header("Location: ../../index.php");
}
	// On vérifie que le film n'existe pas déjà
	$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre = ?');
	$req->execute(array($titre));
if($film = $req->fetch()) {
	$_SESSION['message'] = "Ce film existe déjà";
	$req->closeCursor();
	header("Location: ../../index.php");
} else {
		
	// On insère le film dans la BDD
	$req = $bdd->prepare('INSERT INTO Movie (Titre, Année, Score) VALUES (?, ?, ?)');
	$req->execute(array($titre, $annee, $score));
	$req->closeCursor();

	// On doit récupérer l'id du film inséré pour pouvoir y ajouter les acteurs
	$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre = ?');
	$req->execute(array($titre));
	$film = $req->fetch();
	$id_film = htmlspecialchars($film['MovieID']);
	$req->closeCursor();
	$ordinal = 1;
	while(!feof($fichier)) {
	
		$nom_acteur = fgets($fichier); // On sauvegarde le nom des acteurs
		
		$req = $bdd->prepare('SELECT * FROM Actor WHERE Nom = ?');
		$req->execute(array($nom_acteur));

	// s'il existe déjà on insère juste dans casting
		if($donnees = $req->fetch()) {

			$id_acteur = $donnees['ActorId'];
			$req->closeCursor();
			$req = $bdd->prepare('INSERT INTO Casting (MovieID, ActorId, Ordinal) VALUES (?, ?, ?)');
			$req->execute(array($id_film, $id_acteur, $ordinal));
			$req->closeCursor();
		} else {

	// Sinon on ajoute l'acteur et on l'ajoute dans casting
			$req = $bdd->prepare('INSERT INTO Actor (Nom) VALUES (?)');
			$req->execute(array($nom_acteur));
			$req->closeCursor();

			$req = $bdd->prepare('SELECT * FROM Actor WHERE Nom = ?');
			$req->execute(array($nom_acteur));
			$donnees = $req->fetch();
			$id_acteur = $donnees['ActorId'];
			$req->closeCursor();

			$req = $bdd->prepare('INSERT INTO Casting (MovieID, ActorId, Ordinal) VALUES (?, ?, ?)');
			$req->execute(array($id_film, $id_acteur, $ordinal));
			$req->closeCursor();
		}

		$ordinal++;
				
		}
		$_SESSION['message'] = "Le film a bien été ajouté !";
		header("Location: ../../index.php");
	}
		 
fclose($fichier);
?>