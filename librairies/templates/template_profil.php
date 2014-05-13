<?php
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
?> 