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
		<link rel="stylesheet" href="css/style_scores.css" type ="text/css" />
		<title>Révise tes maths</title>
	</head>
	<body>
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
		<h1>Mes scores</h1>

		<?php



			$req = $bdd->prepare('SELECT * FROM Scores WHERE id_user = ?');
			$req->execute(array($_SESSION['id_user']));

			while($score = $req->fetch()) {
				echo '<table>						
						<tr>							
							<th>Score</th>							
								<td>'.$score['score_user'].'</td>						
						</tr>
						<tr>							
							<th>Date</th>							
								<td>'.$score['date_score'].'</td>						
						</tr>											
					</table>';
			}
			$req->closeCursor();

			$req = $bdd->query('SELECT * FROM Classement ORDER BY best_score_user');

			while($classement = $req->fetch()) {
				echo '<table>						
						<tr>							
							<th>Pseudo</th>							
								<td>'.$classement['pseudo_user'].'</td>						
						</tr>
						<tr>							
							<th>Score</th>							
								<td>'.$classement['best_score_user'].'</td>						
						</tr>	
						<tr>							
							<th>Niveau</th>							
								<td>'.$classement['niveau_classement'].'</td>						
						</tr>										
					</table>';
			}
			$req->closeCursor();
		?>

						
		</div>
		
		
	</body>
</html>