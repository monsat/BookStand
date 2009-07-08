$(function(){
	// 共通
	$('html').addClass('JS');
});


var BookStand = {
	
	toggle: function(me ,target) {
		target = target || (me + 'Target');
		$( me ).click( function(){
			$( target ).slideToggle();
		});
	}
};