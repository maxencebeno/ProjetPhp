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
<?php
			$id_film = htmlspecialchars($_GET['id']);
			$req = $bdd->prepare("select * from Movie where MovieID = ?");
			$req->execute(array($id_film));
			$film = $req->fetch();
		?>
		<h1>Détails du film : "<?php echo $film['Titre'];?>"</h1>

		<h2>Informations sur le film : </h2>

			<ul>
				<?php
					echo '<li>Année de tournage : '.$film['Année'].'</li>
					<li>Score du film : '.$film['Score'].'</li>
					<li>Nombre de votes : '.$film['Votes'].'</li>';
				?>
			</ul>	
		<h2>Voter pour ce film : </h2>
		<?php
			// Script qui prend en compte un éventuel vote
			if(ISSET($_POST['nbVote'])) {
				$ok = true;
				$id_user = $_SESSION['id_user'];
				$req = $bdd->prepare("select * from Vote where MovieID = ? AND id_user = ?");
				$req->execute(array($id_film, $id_user));
				if ($vote = $req->fetch()) {
						$ok = false;
						$message = "Vous avez déjà voté pour ce film";
				}
				$req->closeCursor();
				if($ok == true) {
					$req = $bdd->query("UPDATE Movie set Votes = Votes + 1 where MovieID = ".$id_film."");
					$reqAVote = $bdd->prepare("INSERT INTO Vote(id_user, MovieID) VALUES (?, ?)");
					$reqAVote->execute(array($id_user, $id_film));
					$message = "Votre vote a bien été pris en compte";
					header("Location: details.php?id=".$id_film."&amp;message=".$message."");
				}
				else {
					$message = "Vous avez déjà voté pour ce film";
					header("Location: details.php?id=".$id_film."&amp;message=".$message."");
				}
			}
		?>	

			<form method="post" action="" id="form_vote">
				<input type="hidden" name="nbVote">
				<input type="submit" value="Cliquer pour voter !" id="submit_vote">
			</form>

			<?php
				if(!empty($_GET['message'])) {
					$message = htmlspecialchars($_GET['message']);
					echo $message;
				}
			?>

		<h1> Laisser un commentaire </h1>
			<form method="post" action=<?php echo 'src/templates/template_comment.php?id='.$id_film.''; ?> >
				<textarea type="text" name="message" placeholder="Votre commentaire..." id="textarea_comment" maxlength="1000" required></textarea><br />
				<input type="submit" name="envoyer" value="Envoyer" id="submit_comment"> 
			</form>
		<?php
			$req = $bdd->prepare('SELECT * FROM Comment WHERE MovieID = ? ORDER BY id_comment DESC');
			$req->execute(array($id_film));

			while($comment = $req->fetch()) {
				echo '<div class="comment"> 
					<div class="user_name"><strong>'.$comment['prenom_user'].' '.$comment['nom_user'].'</strong></div>
					<div class="user_message">'.$comment['message'].'</div>
				</div>';
			}
			$req->closeCursor();
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