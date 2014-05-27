<?php 
	session_start();
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
	require_once('includes/db_connect.php');
	$bdd = connect_db();	
	require_once('includes/auto_login.php');
	require_once('src/templates/template_profil.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type ="text/css" />
		<link rel="stylesheet" href="css/style_profil.css" type ="text/css" />
		<title>Profil</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<div id="profil_box">
				<h1>Mon profil</h1>
				<div id="main_box">
					<?php 
					// Gestion de l'affichage de l'image de profil
					$image_personnalisee=false; // Initialisation
					
					$req = $bdd->prepare('SELECT * FROM images WHERE id_user = ?');
					$req->execute(array($_SESSION['id_user']));
					if($donnees = $req->fetch()){
						$image_personnalisee=true; // Modification
						$chemin_image = $donnees['chemin_image'];
					}
					$req->closeCursor();
					if(!isset($_GET['update'])){ 
					?>
					<div id="profil_pic" style="background-image: url('<?php if($image_personnalisee==true){echo $chemin_image;}else{echo 'images/avatar.png';}?>')"></div>
					<div id="infos_box">
						<p><span class="infos_box_label">Prénom:</span> <?php echo $_SESSION['prenom']; ?></p>
						<p><span class="infos_box_label">Nom:</span> <?php echo $_SESSION['nom']; ?></p>
						<p><span class="infos_box_label">Pseudo:</span> <?php echo $_SESSION['pseudo']; ?></p>
						<p><span class="infos_box_label">E-mail:</span> <?php echo $_SESSION['mail']; ?></p>
						<p><span class="infos_box_label">Date d'inscription:</span> <?php echo $_SESSION['date_inscription']; ?></p>
					</div>
					<?php
					}else{
					?>
					<h3 style="margin-top: 40px">Changement de mot de passe</h3>
					<form method="POST" action="#" id="form_update">
						<input type="password" name="old_password" placeholder="Ancien mot de passe" maxlength="20" id="old_password" required /><br />
						<input type="password" name="new_password" placeholder="Nouveau mot de passe" maxlength="20" id="new_password" required /><br />
						<input type="submit" value="Enregistrer" class="submit"/><br />
						<?php if(isset($erreur_register)){echo '<p style="color: red;margin-top: 20px">'.$erreur_register.'</p>';} ?>
						<?php if(isset($succes_register)){echo '<p style="color: green;margin-top: 20px">'.$succes_register.'</p>';} ?>
					</form>
					
					<h3 style="margin-top: 70px">Modifier ma photo de profil (Taille max: 5mo)</h3>
					<form enctype="multipart/form-data" action="profil.php?update" method="post">
						<p><input type="file" name="file" required /><br />
						<input type="submit" value="Enregistrer" class="submit"/></p>
					</form>
					<?php if(isset($image_personnalisee) AND $image_personnalisee==true){?>
					<p><a href="profil.php?update&reset_profile_pic" title="Cliquer ici pour remettre l'image par défaut.">Réinitialiser ma photo de profil</a></p>
					<?php 
					}
					if(isset($erreur_upload)){ echo $erreur_upload; }
					if($img_reset==true){ echo '<p style="color: green">Votre image a bien été réinitialisée. Cliquez <a href="profil.php">ici</a> pour la voir !</p>'; }
					?>
					<?php } ?>
				</div>
				<?php 
				if(!isset($_GET['update'])){
					echo '<a href="profil.php?update"><button id="update_button" style="position: absolute; right:0;top: 50px">Modifier ces informations</button></a>'; 
					}else{
						echo '<a href="profil.php"><button id="update_button" style="position: absolute; right:0;top: 50px">Revenir à mes infos</button></a>';
					}

				?>
			</div>
		</div>

	</body>
</html>