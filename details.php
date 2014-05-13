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
		<title>MEGACINE</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
<?php
			$id_film = htmlspecialchars($_GET['id']);
			$req = $bdd->prepare("select * from Movie where MovieID = ?");
			$req->execute(array($id_film));
			$film = $req->fetch();
		?>
		<h1>Détails du film : <?php echo $film['Titre'];?></h1>

		<h2>Informations sur le film : </h2>

			<ul>
				<?php
					echo '<li>année de tournage : '.$film['Année'].'</li>
					<li>Score du film : '.$film['Score'].'</li>
					<li>Nombre de votes : '.$film['Votes'].'</li>';
				?>
			</ul>	
		<h2>Voter pour ce film : </h2>
		<?php
			if(ISSET($_POST['nbVote'])) {
				$ok = true;
				$id_user = $_SESSION['id_user'];
				$req = $bdd->prepare("select * from Vote where MovieID = ? AND id_user = ?");
				$req->execute(array($id_film, $id_user));
				if ($vote = $req->fetch()) {
						$ok = false;
				}
				$req->closeCursor();
				if($ok) {
					$req = $bdd->query("UPDATE Movie set Votes = Votes + 1 where MovieID = ".$id_film."");
					$reqAVote = $bdd->prepare("INSERT INTO Vote(id_user, MovieID) VALUES (?, ?)");
					$reqAVote->execute(array($id_user, $id_film));
					echo "Votre vote a bien été pris en compte";
					header("Location: details.php");
				}
				else {
					echo "Vous avez déjà voté";
					header("Location: details.php");
				}
			}
		?>	

			<form method="post" action="#">
				<input type="hidden" name="nbVote">
				<input type="submit" value="Voter">
			</form>


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
						<td>'.$cast['Nom'].'</td>
					</tr>';
				}
				$req1->closeCursor();
				?>
			</table>
			<a id="detail" href="index.php">Retour à l'accueil</a>
		</div>
	</body>
</html>