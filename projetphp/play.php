<?php 
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();	
	require_once('includes/auto_login.php');
	require('librairies/templates/insert.php');
	require('librairies/templates/template_classement.php');
	if(!isset($_SESSION['estConnecte'])){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/style.css" type ="text/css" />
		<link rel="stylesheet" href="css/style_play.css" type ="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<title>Révise tes maths</title>
	</head>
	<body onload="document.getElementById('answer').focus();">
		<?php include('includes/header.php'); ?>
		<div id="wrapper">
		
			<?php

			/*================ Calcul du score =========================

			le score démarre à 0.

			On le calcul grâce aux séries de bonnes réponses, aux bonnes réponses.

			On l'incrémente à chaque bonne réponse, on l'incrémente de façon bonus pour les séries de 5 bonnes réponses à la suite.

			Si on peut on incrémente de façon bonus s'il arrive à répondre en moins de 2 secondes.

			En gros : 
				
				$score = 0;

				if(bonne réponse) {$score += 50;}
				else {$score -= 10;}

				if(5 bonnes réponses à la suite) {$score += 100;}
				else {on continue}

				if(temps <= 2sec) {$score += 100;}
				else {on continue}
				
			==========================================================*/

				// Si l'utilisateur clique sur 'jouer'
				if(isset($_GET['on'])){
					header('Location: ?n=1');
				}
				
				// Sinon on l'invite à jouer
				if(!isset($_GET['on']) AND !isset($_GET['n'])){
					echo '<a href="?on" title="Clique ici pour jouer !">Commencer une partie</a>';
				}
				
				if(isset($_GET['n'])){
					$_GET['n'] = (int) $_GET['n'];
					if($_GET['n']==0){
						echo '<p class="piratage">Erreur, fumier: tu as voulu jouer au petit con, tu as perdu.</p>';
						echo '<p id="restart"><a href="play.php?on">Recommencer la partie</a></p>';
					}else{
						// Si c'est la première question
						if($_GET['n'] == 1){
							$_SESSION['n'] = 1;
							$_SESSION['score'] = 0;
							$_SESSION['serie'] = 0;
							$_SESSION['repFausse'] = 0;
							$_SESSION['repJuste'] = 0;
							$_SESSION['ratio'] = 0;
						}

						// On définit le score, on vérifie le résultat et on incrémente le score
						$_SESSION['score'];
						$_SESSION['serie'];
						$_SESSION['repFausse'];
						$_SESSION['repJuste'];
						$_SESSION['ratio'];
						if($_SESSION['n'] > 1 AND $_SESSION['n'] <= 21) {
							if (isset($_POST['resultat']) AND $_POST['resultat'] == $_SESSION['a'] * $_SESSION['b']) {
								$_SESSION['score'] += 50;
								$_SESSION['serie']++;
								$_SESSION['repJuste']++;
								$res2=true;

								if($_SESSION['serie'] == 5) {
									$_SESSION['serie'] = 0;
									$_SESSION['score'] += 100;
									echo '<p id="resultat_courant">Bravo ! Série de 5 ! +100 points</p>';
								}
							}
							else {
								$_SESSION['score'] -= 10;
								$_SESSION['serie'] = 0;
								$_SESSION['repFausse']++;
								$res = true;
							}
						}
						
						// Si le mec ne pirate pas
						if($_GET['n'] == $_SESSION['n']){
							echo '<a href="?on">Recommencer la partie</a>';

							// On va jusqu'à 21 pour qu'il réponse bien à 20 question
							// si le score <= 1400 on lui annonce, sinon c'est qu'il a piraté
							if($_SESSION['n'] == 21 AND $_SESSION['score'] <= 1400) { 
								$repJuste = $_SESSION['repJuste'];
								$repFausse = $_SESSION['repFausse'];
								if($repFausse == 0) {
									$repFausse = 1;
								}
								$ratio = $repJuste / $repFausse;
								$score = $_SESSION['score'];
								$id_user = $_SESSION['id_user'];
								inserer_score($score, $id_user, $bdd);
								inserer_classement($score, $id_user, $bdd, 1);
							}else {
								echo '<div id="main_div">';
								echo '<div id="div_answer">';
								echo '<h1>Question '.$_GET['n'].'</h1>';
								$a = rand (1, 10);
								$b = rand(1, 10);
								$surScore = $_GET['n'] - 1;
								
													
								
								$_SESSION['n']++; // Le faire dès maintenant empêche le refresh de la page ($_SESSION['n'] sera !=)
								$_GET['n']++;
								$_SESSION['a'] = $a;
								$_SESSION['b'] = $b;
								
								// On affiche formulaire
								echo '<p id="question">Combien font '.$a.' X '.$b.' ?</p>';
								echo '<form method="post" action="?n='.$_GET['n'].'">
										<input type="text" name="resultat" id="answer" autocomplete="off" placeholder="Ta réponse..." required/><br />
										<input type="submit" value="Répondre !" id="submit" name="bouton">
									 </form>';
								echo '</div>';
							
							if(true){
							?>
							<!-- Compteur -->
								<script src="js/play.js"></script>
								<script>
									$(function(){
										$('#counter').countdown({
											image: 'images/digits.png',
											startTime: '00:30',
											timerEnd: function(){ window.location = 'play.php?n=<?php echo $_SESSION['n']; ?>' },
										    format: 'mm:ss'
										});
									});
								</script>
								<div id="div_counter">
									<?php
										if(isset($res)){
											echo '<p id="reponse_fausse">Mauvaise réponse...</p>';
											echo '<p id="resultat_courant">Pour l\'instant ton score est de: '.$_SESSION['score'].'</p>';
										}
										
										if(isset($res2)){
											echo '<p id="reponse_juste">Bonne réponse !</p>';
											echo '<p id="resultat_courant">Pour l\'instant ton score est de: '.$_SESSION['score'].'</p>';
										}
										
										if($_SESSION['n']==2){
											echo '<h1>C\'est parti !</h1>';
										}
									?>
									<div id="counter"></div>
									<div class="desc">
									<div id="counter_2"></div>
								</div>
								<!-- Fin compteur -->
							<?php
								echo '</div>';
							}
							
						}
					}
						else{
							echo '<p class="piratage">Erreur, fumier: tu as voulu jouer au petit con, tu as perdu.</p>';
							echo '<p id="restart"><a href="play.php?on">Recommencer la partie</a></p>';
						}
						
					}
				}
			?>
		</div>
		
		
	</body>
</html>