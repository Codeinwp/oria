jQuery(function($) {
	$(".oria-slider .slider-inner").owlCarousel({  
        items : 5,
        itemsCustom : false,
        singleItem: false,
        itemsDesktop : [1199,5],
        itemsDesktopSmall : [980,3],
        itemsTablet: [768,2],
        itemsTabletSmall: false,
        itemsMobile : [479,1],
        autoPlay : +sliderOptions.slideshowspeed,
        stopOnHover : true,
        navigation : true,
        navigationText : ["<i class='fa fa-long-arrow-left'></i>","<i class='fa fa-long-arrow-right'></i>"],
        rewindNav : true,
        pagination : false,
        autoHeight : true,
	})
});

jQuery(function($) {
    $(window).bind('load', function() {
        $('.oria-slider .slider-inner').fadeIn();
    }); 
});
