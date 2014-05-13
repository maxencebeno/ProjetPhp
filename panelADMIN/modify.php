<?php
	session_start();
	require_once('../includes/db_connect.php');
	$bdd = connect_db();
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
		<?php include('includes/header_admin.php'); ?>
		<div id="wrapper">
<?php
			$id_film = htmlspecialchars($_GET['id']);
			$req = $bdd->prepare("select * from Movie where MovieID = ?");
			$req->execute(array($id_film));
			$film = $req->fetch();
		?>

		<h1>Détails du film : "<?php echo $film['Titre'];?>"</h1> 
		<form method="post" action=<?php echo 'modify.php?id='.$id_film.''; ?> >
			<input type="submit" name="changer_titre" value="Changer">
		</form>
			
		<?php
			if(isset($_POST['changer_titre'])) {
				?> <formmethod="post" action=<?php echo 'modify.php?id='.$id_film.''; ?> >
						<input type="text" name="titre" placeholder="Nouveau titre" required>
						<input type="submit" value="Envoyer">
					</form> 
				<?php
			}
		?>
		<h2>Informations sur le film : </h2>

			<ul>
				<?php
					echo '<li>Année de tournage : '.$film['Année'].'</li>
					<li>Score du film : '.$film['Score'].'</li>
					<li>Nombre de votes : '.$film['Votes'].'</li>';
				?>
			</ul>	
			<form method="post" action=<?php echo 'modify.php?id='.$id_film.''; ?> >
				<input type="submit" name="changer_info" value="Changer">
			</form>
			
		<?php
			if(isset($_POST['changer_info'])) {
				?> <form method="post" action=<?php echo 'modify.php?id='.$id_film.''; ?> >
						<input type="text" name="annee" placeholder="Année" required>
						<input type="text" name="score" placeholder="Score" required>
						<input type="text" name="votes" placeholder="Votes" required>
						<input type="submit" value="Envoyer">
					</form> 
				<?php
			}
		?>

		<h2>Casting du film : </h2>
			<?php
					$req1 = $bdd->prepare("select * from Casting, Actor where MovieID = ".$id_film." AND Actor.ActorId = Casting.ActorId ORDER BY Ordinal");
					$req1->execute(array($id_film));
					$cast = $req->fetch();
			?>
			<table id="table-films">
			<tr>
				<th>Id acteur</th> 
				<th>Nom de l'acteur</th>
			</tr>

				<?php
				while($cast = $req1->fetch()) {
					echo ' 
					<tr>
						<td>'.$cast['Ordinal'].'</td> 
						<td>'.$cast['Nom'].'<form><input type="checkbox"></form></td>
					</tr>';
				}
				$req1->closeCursor();
				?>
			 
			</table>
			<form method="post" action=<?php echo 'modify.php?id='.$id_film.''; ?> >
			 	<input type="submit" value="Ajouter">
				<input type="submit" value="Supprimer">
			</form> 
			<a id="detail" href="index.php">Retour à l'accueil</a>
		</div>
	</body>
</html>