<?php

if (isset($_POST['city']) && isset($_POST['min']) && isset($_POST['max'])){
	$data = array(
		'city' => $_POST['city'],
		'min' => $_POST['min'],
		'max' => $_POST['max']
	);

	$sanitizedData = filter_var_array($data, array(
		'city' => FILTER_SANITIZE_STRING,
		'min' => FILTER_SANITIZE_NUMBER_INT,
		'max' => FILTER_SANITIZE_NUMBER_INT
	));

	try { //                 Serveur        Nom de la DB     Encodage      Utilisateur & mdp
		$db = new PDO('mysql:host=localhost;dbname=exercices_mysql charset=utf8','root','');
	} catch (exception $e) {
		die('Erreur: '.$e->getMessage());
	}

	
}