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
		<link rel="stylesheet" href="../css/style_search.css" type ="text/css" />
		<title>MEGACINE</title>
	</head>
	<body onload="document.getElementById('query').focus();">
		<?php include('includes/header_admin.php'); ?>
		<div id="wrapper">
			<?php 
				if(!isset($_GET['q'])){
			?>
			<form method="GET" action="search" id="form_query">
				<h1>Rechercher un film</h1>
				<input type="text" name="q" id="query" minlength="2" maxlength="40" autocomplete="off" /><br />
				<input type="submit" value="Rechercher" id="submit"/>
			</form>
			<?php
				}
				else{
					// Si l'utilisateur a envoyé des données on délègue le traitement de la rechercher à la page incluse ci-dessous
					include('librairies/templates/template_search.php');
				}
			?>
		</div>
		
		
	</body>
</html>