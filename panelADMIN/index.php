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
							</tr>';
					}
					$req->closeCursor();
				?>

			</table>
		</div>
	</body>
</html>