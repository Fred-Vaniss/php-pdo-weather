<?php
if (isset($_POST['id'])){
	// Désinfection de la variable reçue
	$idToDel = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

	// Connection à la BDD
	try { //           Serveur              Nom de la DB           Encodage      Utilisateur & mdp
		$db = new PDO('mysql:host=localhost;dbname=exercices_mysql;charset=utf8','root','');
	} catch (exception $e) {
		die('Erreur: '.$e->getMessage());
	}

	// Préparation de la requête SQL
	$request = $db->prepare('	DELETE FROM weather
								WHERE id = ?');

	// Exécution de la requête SQL avec l'ID à supprimer
	$request->execute([$idToDel]);

	//Clore la requête
	$request->closeCursor();
	$request = NULL;
}