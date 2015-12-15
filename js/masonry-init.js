
//Masonry init
jQuery(function($) {

	var $container = $('.posts-layout');
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: '.posts-layout .hentry',
			columnWidth : '.item-sizer',					
	        isAnimated: true,
			animationOptions: {
				duration: 500,
				easing: 'linear',
			}
	    });
	});

});

