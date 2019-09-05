<?php

if (isset($_POST['id'])){
	$idToDel = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

	try { //           Serveur              Nom de la DB           Encodage      Utilisateur & mdp
		$db = new PDO('mysql:host=localhost;dbname=exercices_mysql;charset=utf8','root','');
	} catch (exception $e) {
		die('Erreur: '.$e->getMessage());
	}

	$request = $db->prepare('	DELETE FROM weather
								WHERE id = :id');

	$request->execute([':id' => $idToDel]);
}