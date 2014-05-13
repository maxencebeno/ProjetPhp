<?php 
	session_start();
	require_once('includes/db_connect.php');
	$bdd = connect_db();
	//-----------------------------------------------------------------
	// Si un pirate viens sur cette page sans etre co, on redirige pr éviter des bugs
	//-----------------------------------------------------------------
	if(!isset($_SESSION['id_user']))
	{
		header('Location: index.php');
	}
	//-----------------------------------------------------------------
	// Suppression des variables de sessions
	//-----------------------------------------------------------------
	session_destroy();
	//-----------------------------------------------------------------
	//Suppression des cookies etc
	//-----------------------------------------------------------------
	setcookie('pseudo', '', time() - 1, '/', null, false, true);
	setcookie('datr', '', time() - 1, '/', null, false, true);
	unset($_COOKIE['pseudo']);
	unset($_COOKIE['datr']);
	//-----------------------------------------------------------------
	//On remet log_key à zéro dans la base de donnée: impossible à l'avenir de se connecter avec la log_key utilisée par le passé
	//-----------------------------------------------------------------
	$req = $bdd->prepare('UPDATE user SET log_key = :log_key WHERE id_user = :id_user');
	$req->execute(array(
						'log_key' => 0,
						'id_user' => $_SESSION['id_user']
		));
	header("Location: index.php");
?>