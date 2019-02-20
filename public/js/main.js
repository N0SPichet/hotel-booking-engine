$( document ).ready(function() {
	if($('#gender').text() === '1')
	{
		$('#gender').text('Male')
	}
	else if($('#gender').text() === '2')
	{
		$('#gender').text('Female')
	}

	/* This is basic - uses default settings */
	$("a#single_image").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	200, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
	/* Using custom settings */
	$("a#inline").fancybox({
		'hideOnContentClick': true
	});
	/* Apply fancybox to multiple items */
	$("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
});