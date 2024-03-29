<?php
	// Ouverture de la session pour réceptionner une message d'erreur si il y en a une
	session_start();

	//Fonction de liste des éléments contenu dans la BDD (exécuté à la ligne 52)
	function fetchData () {
		// Connection à la BDD
		try { //           Serveur              Nom de la DB            Encodage      Utilisateur & mdp
			$db = new PDO('mysql:host=localhost;dbname=exercices_mysql; charset=utf8','root','');
		} catch (exception $e) {
			die('Erreur: '.$e->getMessage());
		}
	
		// Préparation de la requête SQL
		$result =  $db->query('SELECT * FROM weather');
	
		// Exécution de la requête et lister les différents éléments contenu dans le tableau
		while ($data = $result->fetch()){
			echo '<tr>';
			echo '	<td> <input type="checkbox" class="delete" value="'.$data['id'].'" title="Supprimer"> '.$data['ville'].'</td>';
			echo '	<td>'.$data['haut'].'</td>';
			echo '	<td>'.$data['bas'].'</td>';
			echo '</tr>';
		}
	}

	//Fonction d'affichage de message d'erreur (exécuté à la ligne 67)
	function errorMsg() {
		if(isset($_SESSION['errorMsg'])){
			// Affichage du message d'erreur
			echo '<div style="color: red;">';
			echo $_SESSION['errorMsg'];
			echo '</div>';

			// Suppression du message
			unset($_SESSION['errorMsg']);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>WeatherApp</title>
</head>
<body>
	<div class="container">
		<table class='table table-bordered table-sm table-hover mt-3'>
			<tr>
				<th scope="col">Ville</th>
				<th scope="col">Minima</th>
				<th scope="col">Maxima</th>
			</tr>
			<?php fetchData(); ?>
		</table>
		<form action="form.php" method="post">
			<div class="form-row">
				<div class="col-7">
					<input name='city' type="text" class='form-control' placeholder='Ville'>
				</div>
				<div class="col">
					<input name='min' type="text" class='form-control' placeholder='Minima'>
				</div>
				<div class="col">
					<input name='max' type="text" class='form-control' placeholder='Maxima'>
				</div>
				<button type='submit' class='btn btn-primary'>Envoyer</button>
			</div>
			<?php errorMsg() ?>
    	</form>
	</div>

	<script src="main.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>