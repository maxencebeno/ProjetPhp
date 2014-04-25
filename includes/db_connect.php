<?php
			function connect_db(){
				$host = 'localhost';
				$user = 'root';
				$password = 'root';
				$dataBaseName = 'reviseTesMaths';
				try{
					$bdd = new PDO('mysql:host='.$host.';dbname='.$dataBaseName, $user, $password);
				}catch(Exception $e){
					die('Erreur : '.$e->getMessage());
				}
				$bdd->exec('SET NAMES utf8');
				return $bdd;
			}
		?>