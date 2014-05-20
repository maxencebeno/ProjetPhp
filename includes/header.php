<header>
	<nav id="menu">
		<ul>
			<li><a href="index.php">Accueil</a></li>
			<?php 
			if(isset($_SESSION['estConnecte']) AND ($_SESSION['estConnecte'] == true)) {
				echo '<li><a href="search.php">Rechercher un film</a></li>';
				echo '<li><a href="profil.php">Mon profil</a></li>';
				echo '<li style="float: right"><a href="logout.php">Déconnexion</a></li>';
			}else{
				echo'<li><a href="create-account.php">Inscription</a></li>';
				?>
				<form method="post" action="login.php" id="form_login">
					<input type="text" name="pseudo" placeholder="Pseudo" maxlength="20" id="pseudo_login" required />
					<input type="password" name="password" placeholder="Mot de passe" maxlength="40" id="password_login" required />
					<input type="checkbox" name="auto_login" id="auto_login" checked="checked" />
					<label for="auto_login" id="label_auto_login">Se souvenir de moi</label>
					<input type="submit" value="Connexion" id="submit_login" />
				</form>
				<?php
			}
			?>
		</ul>
	</nav>
</header>