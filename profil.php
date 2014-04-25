<?php 
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();	
	require_once('includes/auto_login.php');
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type ="text/css" />
		<link rel="stylesheet" href="css/style_profil.css" type ="text/css" />
		<title>Révise tes maths</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<div id="profil_box">
				<h1>Mon profil</h1>
				<div id="main_box">
					<div id="profil_pic"><img src="images/avatar.png" alt="profile_picture"/></div>
					<div id="infos_box">
						<p><span class="infos_box_label">Prénom:</span> <?php echo $_SESSION['prenom']; ?></p>
						<p><span class="infos_box_label">Nom:</span> <?php echo $_SESSION['nom']; ?></p>
						<p><span class="infos_box_label">Pseudo:</span> <?php echo $_SESSION['pseudo']; ?></p>
						<p><span class="infos_box_label">E-mail:</span> <?php echo $_SESSION['mail']; ?></p>
						<p><span class="infos_box_label">Date d'inscription:</span> <?php echo $_SESSION['date_inscription']; ?></p>
					</div>
				</div>
				<a href="profil.php?c=update"><button id="update_button">Modifier ces informations</button></a>
			</div>
		</div>

	</body>
</html>