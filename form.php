<?php
session_start();

if (isset($_POST['city']) && isset($_POST['min']) && isset($_POST['max'])){
	$post = array(
		'city' => $_POST['city'],
		'min' => $_POST['min'],
		'max' => $_POST['max']
	);

	$isStrlen = (strlen($_POST['city']) < 3) ? true : false;
	$isNumMin = is_numeric($_POST['min']);
	$isNumMax = is_numeric($_POST['max']);
	$isInferior = ($_POST['min'] > $_POST['max']) ? true : false;

	if($isStrlen || $isInferior || !$isNumMin || !$isNumMax){
		if($isStrlen){
			$_SESSION['errorMsg'] = 'Le nom de la ville est trop courte';
		} else if (!$isNumMin || !$isNumMax){
			$_SESSION['errorMsg'] = 'Une des températures ne sont pas un nombre valide';
		} else if ($isInferior){
			$_SESSION['errorMsg'] = 'La température minimale ne peut pas être plus haut que celui du maximale.';
		}
		header('Location: index.php');
		return;
	}

	$data = filter_var_array($post, array(
		'city' => FILTER_SANITIZE_STRING,
		'min' => FILTER_SANITIZE_NUMBER_INT,
		'max' => FILTER_SANITIZE_NUMBER_INT
	));

	try { //           Serveur        		Nom de la DB     	   Encodage      Utilisateur & mdp
		$db = new PDO('mysql:host=localhost;dbname=exercices_mysql;charset=utf8','root','');
	} catch (exception $e) {
		die('Erreur: '.$e->getMessage());
	}

	$request = $db->prepare('	INSERT INTO weather(ville, haut, bas)
								VALUES(?, ?, ?)');

	$request->execute(array($data['city'],$data['min'],$data['max']));

	header('Location: index.php');
}