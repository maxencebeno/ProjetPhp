<?php
	require_once('../includes/db_connect.php');
	$bdd = connect_db();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MEGACINE</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="../css/style_area.css" type ="text/css" />
		<meta charset="UTF-8">
	</head>
	<body>
		<?php include('includes/header_admin.php'); ?>
			<div id="wrapper">
			<h1>MEGACINE</h1>
			<article>
				<p>Bienvenue sur la page d'administration du site. On y ajoute, supprime ou modifie les films présents.</p>
			<article>

				<h1>Liste des films</h1>

				<p> Pour l'ajout d'un acteur : rendez-vous sur la page du film auquel il a participé. </p>

				<form id="formulaire_film" method="post" action="index.php">
					<input type="submit" name="ajout_film" value="Ajouter un film">
				</form>
			
				<?php
					if(isset($_POST['ajout_film'])) {
				?>  
				<form id="formulaire_film" method="post" action="librairies/templates/template_movie.php?chgt=ajout_film">
					<input type="text" name="titre_film" placeholder="Titre" required>
					<input type="text" name="annee_film" placeholder="Année" required>
					<input type="text" name="score_film" placeholder="Score" required>
					<input type="submit" value="Envoyer">
				</form> 
				<?php
					}
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
								<td><a id="detail" href="modify.php?id='.$film['MovieID'].'"> Cliquez pour modifier</a>
									<a href="librairies/templates/template_movie.php?id='.$film['MovieID'].'&amp;chgt=suppression_film"><img id="suppr" src="../images/suppr.png"/></a>
								</td>
							</tr>';
					}
					$req->closeCursor();
				?>

			</table>
		</div>
	</body>
</html>