<?php
	if(!isset($_SESSION['id_user']) AND isset($_COOKIE['pseudo']) AND isset($_COOKIE['datr']))
	{
			$_COOKIE['pseudo']=htmlspecialchars($_COOKIE['pseudo']);
			$_COOKIE['datr']=htmlspecialchars($_COOKIE['datr']);
			
			$req = $bdd->prepare('SELECT * FROM user WHERE pseudo_user = :pseudo AND log_key = :log_key');
			$req->execute(array(
								'pseudo'=> $_COOKIE['pseudo'],
								'log_key'=> $_COOKIE['datr']));
						
			$donnees = $req->fetch();

				if($donnees)
				{
					$_SESSION['id_user'] = htmlspecialchars($donnees['id_user']);
					$_SESSION['nom'] = htmlspecialchars($donnees['nom_user']);
					$_SESSION['pseudo'] = htmlspecialchars($donnees['pseudo_user']);
					$_SESSION['prenom'] = htmlspecialchars($donnees['prenom_user']);
					$_SESSION['mail'] = htmlspecialchars($donnees['mail_user']);
					$_SESSION['date_inscription'] = htmlspecialchars($donnees['date_inscription']);
					$_SESSION['estConnecte'] = true;
					
					$req->closeCursor();
				}
	}
