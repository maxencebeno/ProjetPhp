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
		<link rel="stylesheet" href="css/style_area.css" type ="text/css" />
		<title>MEGACINE</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
			<h1><?php echo $_SESSION['prenom'].' '. $_SESSION['nom']?></h1>
			<p>Cherchez un film dans notre base de données:</p>

			<h1>Liste des films</h1>
			<?php
				$req = $bdd->query("select count(*) as nb_film from Movie");
				$donnee = $req->fetch();
				echo '<p> Il y a actuellement : '.$donnee['nb_film'].' films</p>';
				$req->closeCursor();
			?>

		<table id="table-films">
			<tr>
				<th>Titre</th> 
				<th>Année</th>
				<th>Score</th>
				<th>Votes</th>
				<th>Détails</th>
			</tr>
			<?php
			$req = $bdd->query("select * from Movie");
			while($film = $req->fetch()) {			
				echo ' 
					<tr>
						<td>'.$film['Titre'].'</td> 
						<td>'.$film['Année'].'</td>
						<td>'.$film['Score'].'</td>
						<td>'.$film['Votes'].'</td>	
						<td><a id="detail" href="details.php?id='.$film['MovieID'].'"> Cliquez pour les détails</a>
					</tr>';
			}
			$req->closeCursor();
			?>
			</table>
		</div>
	</body>
</html>