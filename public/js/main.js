$( document ).ready(function() {	
	if($('#gender').text() === '1')
	{
		$('#gender').text('Male')
	}
	else if($('#gender').text() === '2')
	{
		$('#gender').text('Female')
	}
});