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
		<link rel="stylesheet" href="css/style_details.css" type ="text/css" />
		<title>MEGACINE</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			
		<h1> Laisser un avis sur le site (les bugs ou autres problèmes rencontrés) </h1>
			<form method="post" action="librairies/templates/template_feedbacks.php">
				<textarea type="text" name="message" placeholder="Votre feedback..." id="textarea_comment" maxlength="1000" required></textarea><br />
				<input type="submit" name="envoyer" value="Envoyer" id="submit_comment"> 
			</form>
		<?php
			$req = $bdd->query('SELECT * FROM Feedbacks ORDER BY id_feedback DESC');

			while($feedback = $req->fetch()) {
				if($feedback['done'] == false) {
					echo 'Feedbacks non traités encore : ';
					echo '<div class="comment"> 
					<div class="user_name"><strong>'.$feedback['prenom_user'].' '.$feedback['nom_user'].'</strong></div>
					<div class="user_message">'.$feedback['message'].'</div>
				</div>';
				} else {
					echo 'Feedbacks traités : ';
					echo '<div class="comment"> 
					<div class="user_name"><strong>'.$feedback['prenom_user'].' '.$feedback['nom_user'].'</strong></div>
					<div class="user_message">'.$feedback['message'].'</div>
				</div>';
				}
			}
			$req->closeCursor();
		?>

			<a id="detail" href="index.php">Retour à l'accueil</a>
		</div>
	</body>
</html>