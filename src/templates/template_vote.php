<?php
				$id_film = $_GET['id'];
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
					header("Location: ../../details.php?id=".$film['MovieID']."");
				}
				else {
					header("Location: ../../details.php?id=".$film['MovieID']."");
				}
			
?>