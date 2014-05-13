<?php 
	session_start();
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
	require_once('includes/db_connect.php');
	$bdd = connect_db();	
	require_once('includes/auto_login.php');
	require_once('librairies/templates/template_profil.php');
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
					<?php if(!isset($_GET['update'])){ ?>
					<div id="profil_pic"><img src="images/avatar.png" alt="profile_picture"/></div>
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
					<h3>Changement de mot de passe</h3>
					<form method="POST" action="#" id="form_update">
						<input type="password" name="old_password" placeholder="Ancien mot de passe" maxlength="20" id="old_password" required /><br />
						<input type="password" name="new_password" placeholder="Nouveau mot de passe" maxlength="20" id="new_password" required /><br />
						<input type="submit" value="Enregistrer" id="submit"/><br />
						<?php if(isset($erreur_register)){echo '<p style="color: red;margin-top: 20px">'.$erreur_register.'</p>';} ?>
						<?php if(isset($succes_register)){echo '<p style="color: green;margin-top: 20px">'.$succes_register.'</p>';} ?>
					</form>
					<?php } ?>
				</div>
				<?php 
				if(!isset($_GET['update'])){
					echo '<a href="profil.php?update=1"><button id="update_button">Modifier ces informations</button></a>'; 
					}else{
						echo '<a href="profil.php"><button id="update_button">Annuler</button></a>';
					}

				?>
			</div>
		</div>

	</body>
</html>