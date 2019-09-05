let checkboxes = document.getElementsByClassName('delete')

for (const item of checkboxes) {
	item.addEventListener('click', deleteItem)
}

function deleteItem(e) {
	let req = new XMLHttpRequest()

	req.open('POST', 'delete.php', true);

	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

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

	console.log(e.target.value)
}