// Initialize the page
$(document).ready( function () {

	// When the messageData textarea receives focus, remove the sample content
	$('#messageData')[0].focus( function () {
		alert($(this).className);
		if ($(this).className == "sample") {
			alert('still sample!');
		}
	});

});