<?php
	require_once('../../../includes/db_connect.php');
	$bdd = connect_db();

$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("txt");
if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    echo "Le fichier n'a pas l'extension attendue";
} else {    
    // Copie dans le repertoire du script avec un nom
    $repertoireDestination = "Ajout_Film/";
    $nomDestination = $nomOrigine;

    if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                                     $repertoireDestination.$nomDestination)) {
        //header('Location: ../../index.php');
    } else {
       //header('Location: ../../index.php');
    }
}
	$fichier = fopen("Ajout_Film/".$nomOrigine.".txt","r");
	$titre = fgets($fichier);
	$annee = fgets($fichier);
	$score = fgets($fichier);

	$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre = ?');
	$req->execute(array($titre));
	if($film = $req->fetch()) {
		header('Location: ../../index.php');
	} else {
		$req->closeCursor();
		$req = $bdd->prepare('INSERT INTO Movie (Titre, Année, Score) VALUES (?, ?, ?)');
		$req->execute(array($titre, $annee, $score));
		$req->closeCursor();

		$req = $bdd->prepare('SELECT * FROM Movie WHERE Titre = ?');
		$req->execute(array($titre));
		$film = $req->fetch();
		$id_film = htmlspecialchars($film['MovieID']);
		$req->closeCursor();

		$ordinal = 1;

		while (!feof($fichier)) {
			$nom_acteur = fgets($fichier);
		
			if(fgetc($nom_acteur) == '/') {
				header("Location: ../../index.php");
			} else {
				$req = $bdd->prepare('SELECT * FROM Actor WHERE Nom = ?');
				$req->execute(array($nom_acteur));

				if($donnees = $req->fetch()) {

					$id_acteur = $donnees['ActorId'];
					$req->closeCursor();
					$req = $bdd->prepare('INSERT INTO Casting (MovieID, ActorId, Ordinal) VALUES (?, ?, ?)');
					$req->execute(array($id_film, $id_acteur, $ordinal));
					$req->closeCursor();
				} else {

					$req = $bdd->prepare('INSERT INTO Actor (Nom) VALUES (?)');
					$req->execute(array($nom_acteur));
					$req->closeCursor();
				}

				$ordinal++;
			}
			
		}
		fclose($fichier);
	}
	header("Location: ../../index.php");
?>