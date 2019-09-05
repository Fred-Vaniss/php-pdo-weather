// Stockage de tous les cases à cocher
let checkboxes = document.getElementsByClassName('delete')

// Ajout d'event listener à chaque cases à cocher
for (const item of checkboxes) {
	item.addEventListener('click', deleteItem)
}

// Fonction lorsqu'on coche une case
function deleteItem(e) {
	// Préparation de la requête AJAX
	let req = new XMLHttpRequest()
	req.open('POST', 'delete.php', true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	// Envoie de la requête avec le numéro d'ID contenu dans la valeur de la case à cocher
	req.send('id='+e.target.value)

	req.onreadystatechange = function (){
		if(req.readyState === XMLHttpRequest.DONE){
			if(req.status == 200){
				console.log('deleted')
				location.reload();
			} else {
				console.error(`Erreur ${req.status}`);
			}
		}
	}
}