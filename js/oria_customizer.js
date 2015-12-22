/*
Upsells
*/

jQuery(document).ready(function() {

	/* Upsells in customizer (Documentation link and Upgrade to PRO link */


	if( !jQuery( ".oria-upsells" ).length ) {
		jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section oria-upsells" style="padding-bottom: 15px">');
		}

    if( jQuery( ".oria-upsells" ).length ) {

  		jQuery('.oria-upsells').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://github.com/Codeinwp/oria" class="button" target="_blank">{github}</a>'.replace('{github}', oriaCustomizerObject.github));
  		jQuery('.oria-upsells').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/support/view/theme-reviews/oria#postform" class="button" target="_blank">{review}</a>'.replace('{review}', oriaCustomizerObject.review));

  	}

	if ( !jQuery( ".oria-upsells" ).length ) {
		jQuery('#customize-theme-controls > ul').prepend('</li>');
	}
});
