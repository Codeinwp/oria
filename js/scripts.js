
//Menu dropdown animation
jQuery(function($) {
	$('.sub-menu').hide();
	$('.main-navigation .children').hide();
	$('.menu-item').hover( 
		function() {
			$(this).children('.sub-menu').slideDown();
		}, 
		function() {
			$(this).children('.sub-menu').hide();
		}
	);
	$('.main-navigation li').hover( 
		function() {
			$(this).children('.main-navigation .children').slideDown();
		}, 
		function() {
			$(this).children('.main-navigation .children').hide();
		}
	);	
});

//Open social links in a new tab
jQuery(function($) {
     $( '.social-navigation li a' ).attr( 'target','_blank' );
});

//Social menu
jQuery(function($) {
	var items = $('.social-navigation .menu-item').length;
	itemWidth = 100/items + '%';
	$('.social-navigation .menu-item').css('width', itemWidth);
});

//Toggle sidebar
jQuery(function($) {
	$('.sidebar-toggle').click(function() {
		$('.widget-area').toggleClass('widget-area-visible');
		$('.sidebar-toggle').toggleClass('sidebar-toggled');
		$('.sidebar-toggle').find('i').toggleClass('fa-plus fa-times');
	});
	$('.sidebar-close').click(function() {
		$('.widget-area').toggleClass('widget-area-visible');
		$('.sidebar-toggle').find('i').toggleClass('fa-plus fa-times');
	});	
});

//Parallax
jQuery(function($) {
	$(".site-header").parallax("50%", 0.3);
});

//Fit Vids
jQuery(function($) {
    $("body").fitVids();  
});

//Mobile menu
jQuery(function($) {
	$('.main-navigation .menu').slicknav({
		label: '<i class="fa fa-bars"></i>',
		prependTo: '.mobile-nav',
		closedSymbol: '&#43;',
		openedSymbol: '&#45;',
		allowParentLinks: true
	});
	$('.info-close').click(function(){
		$(this).parent().fadeOut();
		return false;
	});
});	

//Preloader
jQuery(function($) {
	$(window).bind('load', function() {
		$('.preloader').css('opacity', 0);
		setTimeout(function(){$('.preloader').hide();}, 600);	
	});
});