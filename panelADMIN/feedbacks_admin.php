<?php
	session_start();
	require_once('../includes/db_connect.php');
	$bdd = connect_db();
	require_once('../includes/auto_login.php');
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../css/style.css" type ="text/css" />
		<link rel="stylesheet" href="../css/style_details.css" type ="text/css" />
		<title>MEGACINE</title>
	</head>
	<body>
		<?php include('../includes/header.php'); ?>
		<div id="wrapper">
			
		<h1> Traiter les feedbacks et régler les bugs </h1>
		
		<?php
			$req = $bdd->query('SELECT * FROM Feedbacks ORDER BY done DESC');

			while($feedback = $req->fetch()) {
				if($feedback['done'] == false) {
					echo 'Feedbacks non traités encore : ';
					echo '<div class="comment"> 
					<div class="user_name"><strong>'.$feedback['prenom_user'].' '.$feedback['nom_user'].'</strong></div>
					<div class="user_message">'.$feedback['message'].'</div>
					<div><form method="post" action="librairies/templates/template_feedbacks_admin.php?id_feedback='.$feedback['id_feedback'].'">
						Traitée <input type="checkbox" name="traite">
						<input type="submit" value="Envoyer" name="envoi_traite">
						</form>
					</div>
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