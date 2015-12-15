<?php
/**
 * @package Oria
 */

//Converts hex colors to rgba
function oria_hex2rgba($color, $opacity = false) {

        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        $rgb =  array_map('hexdec', $hex);
        $opacity = 0.4;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

        return $output;
}

//Dynamic styles
function oria_custom_styles($custom) {

	$custom = '';

	//Primary color
	$primary_color 	= get_theme_mod( 'primary_color', '#EF997F' );
	$rgba 			= oria_hex2rgba($primary_color);
	if ( $primary_color != '#EF997F' ) {
		$custom .= ".footer-widgets .widget-title,.owl-theme .owl-controls .owl-buttons div,.read-more,.entry-title a:hover,a, a:hover { color:" . esc_attr($primary_color) . "}"."\n";
		$custom .= "#preloader-inner,.oria-slider .slide-title a,.read-more:hover,.nav-previous:hover,.nav-next:hover, button,.button,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"] { background-color:" . esc_attr($primary_color) . "}"."\n";
		$custom .= ".widget-title { border-color:" . esc_attr($primary_color) . "}"."\n";	
		$custom .= ".sidebar-toggle,.social-navigation li a:hover,.main-navigation a:hover {background-color:" . esc_attr($rgba) . ";}" . "\n";
	}
	//Body
	$body_text = get_theme_mod( 'body_text_color', '#717376' );
	$custom .= "body, .widget a { color:" . esc_attr($body_text) . "}"."\n";
	//Site title
	$site_title = get_theme_mod( 'site_title_color', '#fff' );
	$custom .= ".site-title a, .site-title a:hover { color:" . esc_attr($site_title) . "}"."\n";
	//Site desc
	$site_desc = get_theme_mod( 'site_desc_color', '#bbb' );
	$custom .= ".site-description { color:" . esc_attr($site_desc) . "}"."\n";
	
	//Logo size
	$logo_size = get_theme_mod( 'logo_size', '200' );
	$custom .= ".site-logo { max-width:" . intval($logo_size) . "px; }"."\n";
	
	//Logo padding
	$branding_padding = get_theme_mod('branding_padding', '80');
	$custom .= ".site-branding { padding-top:" . intval($branding_padding) . "px;padding-bottom:" . intval($branding_padding) . "px; }"."\n";

	//Fonts
	$body_fonts = get_theme_mod('body_font_family');	
	$headings_fonts = get_theme_mod('headings_font_family');
	if ( $body_fonts !='' ) {
		$custom .= "body, .main-navigation ul ul li { font-family:" . $body_fonts . ";}"."\n";
	}
	if ( $headings_fonts !='' ) {
		$custom .= "h1, h2, h3, h4, h5, h6, .main-navigation li { font-family:" . $headings_fonts . ";}"."\n";
	}
    //Site title
    $site_title_size = get_theme_mod( 'site_title_size', '62' );
    if ( $site_title_size) {
        $custom .= ".site-title { font-size:" . intval($site_title_size) . "px; }"."\n";
    }
    //Site description
    $site_desc_size = get_theme_mod( 'site_desc_size', '18' );
    if ( $site_desc_size) {
        $custom .= ".site-description { font-size:" . intval($site_desc_size) . "px; }"."\n";
    }	    	
	//H1 size
	$h1_size = get_theme_mod( 'h1_size' );
	if ( $h1_size) {
		$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
	}
    //H2 size
    $h2_size = get_theme_mod( 'h2_size' );
    if ( $h2_size) {
        $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
    }
    //H3 size
    $h3_size = get_theme_mod( 'h3_size' );
    if ( $h3_size) {
        $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
    }
    //H4 size
    $h4_size = get_theme_mod( 'h4_size' );
    if ( $h4_size) {
        $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
    }
    //H5 size
    $h5_size = get_theme_mod( 'h5_size' );
    if ( $h5_size) {
        $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
    }
    //H6 size
    $h6_size = get_theme_mod( 'h6_size' );
    if ( $h6_size) {
        $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
    }
    //Body size
    $body_size = get_theme_mod( 'body_size' );
    if ( $body_size) {
        $custom .= "body { font-size:" . intval($body_size) . "px; }"."\n";
    }

	//Output all the styles
	wp_add_inline_style( 'oria-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'oria_custom_styles' );