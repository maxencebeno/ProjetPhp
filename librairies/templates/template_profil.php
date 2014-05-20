<?php
	// Si c'est bien le mot de passe que l'utilisateur veut changer
	if(isset($_POST['old_password']) AND isset($_POST['new_password'])){
		$_POST['old_password'] = strip_tags($_POST['old_password']);
		$_POST['new_password'] = strip_tags($_POST['new_password']);
			
		if(!empty($_POST['new_password']) AND !empty($_POST['old_password'])) //check pseudo, nom et prénom pas vide
		{
			if (!strpos($_POST['new_password'], " ")){
				if(strlen($_POST['new_password']) >= 8 AND strlen($_POST['new_password'] <= 40)) // check la longueur du password (entre 8 et 40 car.)
				{
					if(preg_match("#^(?=.*\d)(?=.*[a-z]).{8,20}$#", $_POST['new_password'])) //On teste si il y a bien des chiffres, et des minuscules dans le password
					{
						// On vérifie maintenant que l'ancien mot de passe du compte est correct pour valider le changement
						$req = $bdd->prepare('SELECT * FROM user WHERE id_user = ? AND pass_user = ?');
						$req->execute(array($_SESSION['id_user'], sha1($_POST['old_password'])));
						$resultat = $req->fetch();
						if($resultat){
							// Requete de test
								// Si ok
								$req = $bdd->prepare('UPDATE user SET pass_user = :pass_user WHERE id_user = :id_user');
								$req->execute(array(
											'pass_user' => sha1($_POST['new_password']),
											'id_user' => $_SESSION['id_user']
								));
								$succes_register = 'La modification a bien été prise en compte.';
						}else{
						$erreur_register = 'Erreur: votre ancien mot de passe n\'est pas celui-ci !';
					}
					}else{
						$erreur_register = 'Erreur: votre mot de passe doit contenir au moins une lettre minuscule et un chiffre !';
					}
				}else{
					$erreur_register = 'Erreur: votre mot de passe doit faire entre 8 et 40 caractères !';
				}
			}else{
				$erreur_register = 'Erreur: votre mot de passe ne doit pas contenir d\'espaces !';
			}
		}else{
			$erreur_register = 'Erreur: vous devez indiquer votre mot de passe !';
		}
	}


	// Si c'est l'image de profil que l'utilisateur veut changer
	if(isset($_FILES['file'])){
		if($_FILES['file']['error'] === 0){
			$nom = $_FILES['file']['name'];
			$infosfichier = pathinfo($_FILES['file']['name']);
			$extension_upload = $infosfichier['extension'];
			$extensions_autorisees = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
			if (in_array($extension_upload, $extensions_autorisees) AND $_FILES['file']['size']<=1000000000){
				$nom_fichier = $_SESSION['id_user'].'.'.$extension_upload;
				$emplacement = 'user_data/profile_pics/'.$nom_fichier;
				
				// On vérifie si l'utilisateur a déjà une photo perso pour mettre à jour au lieu de créer une nouvelle ligne avec son id ! Sinon on aurait une erreur (2 entrées avec le même id_user dans la table "images")
				$deja_photo_perso = false;
				
				$req = $bdd->prepare('SELECT * FROM images WHERE id_user= ?');
				$req->execute(array($_SESSION['id_user']));
				if($donnees = $req->fetch()){
					$deja_photo_perso=true;
					$chemin_ancienne_image = $donnees['chemin_image'];
				}
				$req->closeCursor();
				
				
				
				// Requête pour enregistrer la photo dans le base de données aussi !!
				if($deja_photo_perso==false){ // Si premier upload on crée une entrée dans la table "images"
					$req = $bdd->prepare('INSERT INTO images (id_user, chemin_image) VALUES(?, ?)');
					$req->execute(array($_SESSION['id_user'], $emplacement));
					$req->closeCursor();
				}else{ // Sinon; l'entrée existe déjà, on la met juste à jour. ET ON SUPPRIME LA PHOTO PRECEDENTE EN PHP SUR LE SERVEUR !
					unlink($chemin_ancienne_image);
					$req = $bdd->prepare('UPDATE images SET chamin = ? WHERE id_user = ?');
					$req->execute(array($_SESSION['id_user'], $emplacement));
					$req->closeCursor();
				}
				
				
				move_uploaded_file($_FILES['file']['tmp_name'], $emplacement);
				$erreur_upload = '<p style="color:green;">Votre image de profil a été mise à jour avec succès! Cliquez <a href="profil.php">ici</a> pour la voir !</p>';
			}
			else{
				$erreur_upload = '<p style="color: red">Fichier invalide ou trop grand. Réessayer avec un autre.</p>';
			}
		}
		else{
			$erreur_upload = '<p style="color: red">Erreur fichier: la définition de l\'image peut-être trop élevée. Réessayez avec une autre.</p>';
		}
	}
	
	// Gère la remise à zéro de l'image de profil si l'utilisateur en a donné l'ordre
	$img_reset = false;
	if(isset($_GET['reset_profile_pic'])){
		$req = $bdd->prepare('DELETE FROM images WHERE id_user = ?');
		$req->execute(array($_SESSION['id_user']));
		$req->closeCursor();
		$img_reset = true;
	}
	
	
	
	
?> 