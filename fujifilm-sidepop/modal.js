jQuery(document).ready(function( $ ) {

	$( "#sidepop-container" ).css("right", $( '#sidepop-container' ).outerHeight()*-1);
	$( "#sidepop-container" ).show();
	$( "#sidepop-container" ).delay( 3000 ).animate({
		right: 0
	}, 500, function() {
		// Animation complete.
	});
	  
});