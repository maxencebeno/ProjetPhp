<?php
	session_start();
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
				<h2 style="color: grey">Bienvenue sur la page d'administration du site. On y ajoute, supprime ou modifie les films présents.</h2>

				<div id="ajout">
					<h1>Ajouter des informations</h1>
					<p><span style="color: #63b4fb;font-weight:bold;text-decoration:underline">Ajouter un acteur :</span> rendez-vous sur la page du film auquel il a participé. </p>
					
					<p style="color: #63b4fb;font-weight:bold;text-decoration:underline">Ajouter un film avec un fichier</p>
					<form enctype="multipart/form-data" action="librairies/templates/template_fileupload.php" method="post">
						<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
						<p style="margin-left: 30px">Choisissez un fichier .txt respectant les normes définies <input type="file" name="monfichier" required/>
						<input type="submit" value="Envoyer"/></p>
					</form>

					<?php
						// Affichage du message de réussite ou d'erreur avec une variable de session (le plus pratique et sécurisé)
						if(isset($_SESSION['message'])) {
							echo '<p style="color: red;font-weight: bold">'.$_SESSION['message'].'</p>';
							unset($_SESSION['message']); // Supprime le message si on rafraichit la page on ne l'affiche plus! 
						}
					?>

					<p style="color: #63b4fb;font-weight:bold;text-decoration:underline">Ajouter un film en remplissant le formulaire</p>
  
					<form id="formulaire_film" method="post" action="librairies/templates/template_movie.php?chgt=ajout_film">
						<p style="margin-left: 30px">
							<input type="text" name="titre_film" placeholder="Titre" required>
							<input type="text" name="annee_film" placeholder="Année" required>
							<input type="text" name="score_film" placeholder="Score" required>
							<input type="submit" value="Envoyer"></p>
					</form> 
				</div>
				
				<h1>Liste des films</h1>
			<table id="table-films">
				<tr>
					<th>Titre</th> 
					<th>Année</th>
					<th>Score</th>
					<th>Votes</th>
					<th>Détails</th>
				</tr>
				<?php
					$req = $bdd->query("select * from Movie ORDER BY Année");
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