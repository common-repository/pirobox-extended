jQuery(function($) {
$('<div class="overlay" />').appendTo('body').css('opacity',0);
$('.help').hover(function(){
	var height = $(document).height();
	var position = $(this).position();
	$('.overlay').show().css({'height':height,'opacity':.5});
	$(this).next('.tooltip').css({
		'left':position.left+30,
		'top':position.top-($(this).next('.tooltip').height()/2)
	}).show();
	},function(){
		$('.overlay').hide();
		$(this).next('.tooltip').hide()
	});
$('.help_images').hover(function(){
	var height = $(document).height();
	var position = $(this).position();
	$('.overlay').show().css({'height':height,'opacity':.5});
	$(this).next('.tooltip_images').css({
		'left':position.left+30,
		'top':position.top-30
	}).show();
	},function(){
		$('.overlay').hide();
		$(this).next('.tooltip_images').hide()
	});
});