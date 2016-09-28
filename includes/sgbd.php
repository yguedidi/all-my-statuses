<?php
	require_once 'defines/sql.php';
	
	// Connexion a la base de données
	$PDO = null;
	
	try {
		$PDO = new PDO(
			'mysql:host='.SQL_HOST.';port='.SQL_PORT.';dbname='.SQL_DB,
			SQL_USER,
			SQL_PASS);
	} catch (PDOException $e) {
		trigger_error('Erreur connexion MySQL : '.$e->getMessage(), E_USER_ERROR);
		exit();
	}
