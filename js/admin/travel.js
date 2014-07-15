jQuery(document).ready( function($) {

	$('h2.nav-tabwrapper').on('click', 'a', function(){
		if($(this).attr('href') == '#tab-1'){
			$('#postdivrich').hide();
		} else {
			$('#postdivrich').show();
		}
	});
});