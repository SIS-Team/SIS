function invertSelection() {
	var array = document.getElementsByClassName("checkbox");
	for (var i = 0; i < array.length; i++) {
		array[i].checked = !array[i].checked;
	}
}