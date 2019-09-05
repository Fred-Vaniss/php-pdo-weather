<?php
// Ouverture de la session pour stocker un message d'erreur si cela arrive
session_start();

if (isset($_POST['city']) && isset($_POST['min']) && isset($_POST['max'])){
	$post = array(
		'city' => $_POST['city'],
		'min' => $_POST['min'],
		'max' => $_POST['max']
	);

	// Vérification si le formulaire est correcte
	$isStrlen = (strlen($_POST['city']) < 3) ? true : false;
	$isNumMin = is_numeric($_POST['min']);
	$isNumMax = is_numeric($_POST['max']);
	$isInferior = ($_POST['min'] > $_POST['max']) ? true : false;

	// Si un des champs n'est pas valide, alors renvoyer un message d'erreur.
	if($isStrlen || $isInferior || !$isNumMin || !$isNumMax){
		if($isStrlen){
			$_SESSION['errorMsg'] = 'Le nom de la ville est trop courte';
		} else if (!$isNumMin || !$isNumMax){
			$_SESSION['errorMsg'] = "Une des températures n'est pas un nombre valide";
		} else if ($isInferior){
			$_SESSION['errorMsg'] = 'La température minimale ne peut pas être plus haut que celui du maximale.';
		}
		header('Location: index.php');
		return;
	}

	// Désinfection des variables
	$data = filter_var_array($post, array(
		'city' => FILTER_SANITIZE_STRING,
		'min' => FILTER_SANITIZE_NUMBER_INT,
		'max' => FILTER_SANITIZE_NUMBER_INT
	));

	// Connection à la base de donnée
	try { //           Serveur        		Nom de la DB     	   Encodage      Utilisateur & mdp
		$db = new PDO('mysql:host=localhost;dbname=exercices_mysql;charset=utf8','root','');
	} catch (exception $e) {
		die('Erreur: '.$e->getMessage());
	}

	// Préparation de la requête SQL
	$request = $db->prepare('	INSERT INTO weather(ville, haut, bas)
								VALUES(?, ?, ?)');

	// Exécution de la requête SQL avec les variables
	$request->execute(array($data['city'],$data['min'],$data['max']));

	//Clore la requête
	$request->closeCursor();
	$request = NULL;

	// Retour à la page index.php
	header('Location: index.php');
}