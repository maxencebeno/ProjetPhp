<?php 
	require("includes/db_connect.php");
	require("src/templates/template_register.php");
	$bdd = connect_db();
	require_once('includes/auto_login.php');
	
	$erreur_register = '';
	
	if(!isset($_SESSION['id_user']))
	{
		// Exécute ce script php Si et Seulement Si le formulaire est envoyé :
		if(isset($_POST['pseudo']) AND isset($_POST['mail']) AND isset($_POST['password']) AND isset($_POST['prenom']) AND isset($_POST['nom']))
		{
			// On enlève les éventuelles injections pirates XSS dans TOUS les champs fournis par le formulaire
			// Avantage: plus besoin de htmlspecialchars() par la suite: toutes les injections de codes sont retirées avant d'aller en BDD!
			$_POST['pseudo'] = strip_tags($_POST['pseudo']);
			$_POST['password'] = strip_tags($_POST['password']);
			$_POST['prenom'] = strip_tags($_POST['prenom']);
			$_POST['nom'] = strip_tags($_POST['nom']);
			$_POST['mail'] = strip_tags($_POST['mail']);
			
			if(!empty($_POST['pseudo']) AND !empty($_POST['nom']) AND !empty($_POST['prenom'])) //check pseudo, nom et prénom pas vide
			{
				if(strlen($_POST['pseudo']) >= 2 AND strlen($_POST['pseudo']) <= 30) //check longueur pseudo (de 2 à 30 caractères)
				{
					if(strlen($_POST['prenom']) >= 2 AND strlen($_POST['prenom']) <= 30) //check longueur prénom (de 2 à 30 caractères)
					{
						if(strlen($_POST['nom']) >= 2 AND strlen($_POST['nom']) <= 30) //check longueur nom (de 2 à 30 caractères)
						{	
							if(!empty($_POST['mail'])) // check mail vide
							{
								if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail'])) //check validité du mail
								{
									if(!empty($_POST['password'])) //check password vide
									{
										if (!strpos($_POST['password'], " "))
										{
											if(strlen($_POST['password']) >= 8 AND strlen($_POST['password'] <= 40)) // check la longueur du password (entre 8 et 40 car.)
											{
												if(preg_match("#^(?=.*\d)(?=.*[a-z]).{8,20}$#", $_POST['password'])) //On teste si il y a bien des chiffres, et des minuscules dans le password
												{
													if(true/*isset($_POST['agree'])*/) // Check que les conditions d'utilisation sont acceptées
													{
														$req = $bdd->prepare('SELECT * FROM user WHERE pseudo_user = ?'); 							
														$req->execute(array($_POST['pseudo']));
											
														$resultat = $req->fetch();
														
														if(!$resultat) // Si le pseudo est libre on continue
														{
																$req->closeCursor();
																$req = $bdd->prepare('SELECT * FROM user WHERE mail_user = ?'); 							
																$req->execute(array($_POST['mail']));
											
																$resultat = $req->fetch();
																
																if(!$resultat) // Si le mail est libre on continue
																{
																	$req->closeCursor();
																	
																	$date = date("Y-m-d");
																	// On insère dans la base de données
																	$req = $bdd->prepare("INSERT INTO user (id_user, pseudo_user, pass_user, mail_user, nom_user, prenom_user, date_inscription) VALUES ('', ?, ?, ?, ?, ?, ?)");
																	$req->execute(array($_POST["pseudo"], sha1($_POST['password']), $_POST["mail"], $_POST["nom"], $_POST["prenom"], $date));

																	$req->closeCursor(); // Ferme la requête
																}
																
																else
																{
																	$erreur_register = 'Erreur: l\'adresse mail "'.$_POST['mail'].'" est déjà utilisée ! Choisissez-en une autre.';
																}
														}
														else
														{
															$erreur_register = 'Erreur: le pseudo "'.$_POST['pseudo'].'" est déjà utilisé ! Choisissez-en un autre.';
														}
													}
													else
													{
														$erreur_register = 'Erreur: vous devez accepter nos conditions d\'utilisation !'; 
													}
												}
												else
												{
													$erreur_register = 'Erreur: votre mot de passe doit contenir au moins une lettre minuscule et un chiffre !';
												}
											}
											else
											{
												$erreur_register = 'Erreur: votre mot de passe doit faire entre 8 et 40 caractères !';
											}
										}
										else
										{
											$erreur_register = 'Erreur: votre mot de passe ne doit pas contenir d\'espaces !';
										}
									}
									else
									{
										$erreur_register = 'Erreur: vous avez oublié d\'indiquer votre mot de passe !'; 
									}
								}
								else
								{
									$erreur_register = 'Erreur: votre adresse mail est incorrecte !'; 
								}
							}
							else
							{
								 $erreur_register = 'Erreur: vous avez oublié d\'indiquer votre mail !';
							}
						}
						else
						{
							$erreur_register = 'Erreur: votre nom doit faire entre 2 et 30 caractères !';
						}
					}
					else
					{
						$erreur_register = 'Erreur: votre prénom doit faire entre 2 et 30 caractères !';
					}
				}
				else
				{
					$erreur_register = 'Erreur: votre pseudo doit faire entre 2 et 30 caractères !';
				}
			
			}
			else
			{
				$erreur_register = 'Erreur: vous avez oublié d\'indiquer votre pseudo, votre prénom ou votre nom !';
			}

		}else{
			header('Location: index.php');
		}
	}
	else if(isset($_SESSION['ID']) AND isset($_POST['password']))
	{
		$erreur_register = 'Erreur lors de la tentative d\'inscription: vous êtes déjà connecté(e) !';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inscription</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<link rel="stylesheet" href="css/style_register.css" type="text/css" />
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
		
			<?php 
			if($erreur_register != ''){
			?>
				<div id="register_box">
					<?php echo '<p id="p_erreur">'.$erreur_register.'</p>'; ?>
					<h1>Créer un compte<h1>
					<form method="POST" action="#" id="form_register2">
						<input type="text" name="pseudo" placeholder="Pseudo" maxlength="20" id="pseudo" required <?php echo pre_remplir($_POST['pseudo']);?>/><br />
						<input type="password" name="password" placeholder="Mot de passe" maxlength="20" id="password" required <?php echo pre_remplir($_POST['password']);?> /><br />
						<input type="text" name="prenom" placeholder="Prénom" maxlength="35" id="prenom" required <?php echo pre_remplir($_POST['prenom']);?> /><br />
						<input type="text" name="nom" placeholder="Nom" maxlength="35" id="nom" required <?php echo pre_remplir($_POST['nom']);?> /><br />
						<input type="email" name="mail" placeholder="E-Mail" maxlength="35" id="mail" required <?php echo pre_remplir($_POST['mail']);?> /><br />
						<input type="submit" value="Inscription" id="submit"/><br />
					</form>
				</div>
			<?php
			}
			else{
				echo '<p style="color: green">Bravo vous êtes inscrit '.$_POST['prenom'].' ! Tu peux cliquer <a href="index.php">ici</a> pour te connecter.</p>';
			}
			?>
			
			
		</div>
	</body>
</html>