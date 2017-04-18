<?php
/**
 * Oria functions and definitions
 *
 * @package Oria
 */

if ( ! function_exists( 'oria_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function oria_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Oria, use a find and replace
	 * to change 'oria' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'oria', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Content width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1170;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('oria-carousel', 390, 260, true);
	add_image_size('oria-small-thumb', 520);
	add_image_size('oria-large-thumb', 740);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'oria' ),
		'social'  => __( 'Social', 'oria' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'oria_custom_background_args', array(
		'default-color' => 'f9f6f5',
		'default-image' => '',
	) ) );
}
endif; // oria_setup
add_action( 'after_setup_theme', 'oria_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function oria_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'oria' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	//Footer widget areas
	$widget_areas = get_theme_mod('footer_widget_areas', '3');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'oria' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}
add_action( 'widgets_init', 'oria_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function oria_scripts() {

	wp_enqueue_style( 'oria-style', get_stylesheet_uri() );

	if ( get_theme_mod('body_font_name') !='' ) {
	    wp_enqueue_style( 'oria-body-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('body_font_name')) );
	} else {
	    wp_enqueue_style( 'oria-body-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
	}

	if ( get_theme_mod('headings_font_name') !='' ) {
	    wp_enqueue_style( 'oria-headings-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('headings_font_name')) );
	} else {
	    wp_enqueue_style( 'oria-headings-fonts', '//fonts.googleapis.com/css?family=Oswald:300,700');
	}

	wp_enqueue_style( 'oria-fontawesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );

	wp_enqueue_script( 'oria-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'oria-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), true );

	wp_enqueue_script( 'oria-slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array('jquery'), true );

	wp_enqueue_script( 'oria-parallax', get_template_directory_uri() . '/js/parallax.min.js', array('jquery'), true );

	wp_enqueue_script( 'oria-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), true );

	wp_enqueue_script( 'oria-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery', 'masonry' ), true );

	wp_enqueue_script( 'oria-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array( 'jquery' ), true );

}
add_action( 'wp_enqueue_scripts', 'oria_scripts' );

/**
 * Enqueue Bootstrap
 */
function oria_enqueue_bootstrap() {
	wp_enqueue_style( 'oria-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'oria_enqueue_bootstrap', 9 );

/**
 * Load html5shiv
 */
function oria_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'oria_html5shiv' );

/**
 * Site branding
 */
if ( ! function_exists( 'oria_branding' ) ) :
function oria_branding() {
	if ( get_theme_mod('site_logo') && get_theme_mod('logo_style', 'hide-title') == 'hide-title' ) :
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr(get_bloginfo('name')) . '"><img class="site-logo" src="' . esc_url(get_theme_mod('site_logo')) . '" alt="' . esc_attr(get_bloginfo('name')) . '" /></a>';
	elseif ( get_theme_mod('logo_style', 'hide-title') == 'show-title' ) : //Show logo, site-title, site-description
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr(get_bloginfo('name')) . '"><img class="site-logo show-title" src="' . esc_url(get_theme_mod('site_logo')) . '" alt="' . esc_attr(get_bloginfo('name')) . '" /></a>';
		echo '<h1 class="site-title"><a href="' . esc_url(home_url( '/' )) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></h1>';
		echo '<h2 class="site-description">' . esc_html(get_bloginfo( 'description' )) . '</h2>';
	else : //Show only site title and description
		echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html(get_bloginfo('name')) . '</a></h1>';
		echo '<h2 class="site-description">' . esc_html(get_bloginfo( 'description' )) . '</h2>';
	endif;
}
endif;

/**
 * Full width single posts
 */
function oria_fullwidth_singles($classes) {
	if ( get_theme_mod('fullwidth_single', 0) ) {
		$classes[] = 'fullwidth-single';
	}
	return $classes;
}
add_filter('body_class', 'oria_fullwidth_singles');

/**
 * Footer credits
 */

function oria_footer_credits() {
	echo '<a href="' . esc_url( __( 'http://wordpress.org/', 'oria' ) ) . '" rel="nofollow">';
		printf( __( 'Proudly powered by %s', 'oria' ), 'WordPress' );
	echo '</a>';
	echo '<span class="sep"> | </span>';
	printf( __( 'Theme: %2$s by %1$s.', 'oria' ), 'JustFreeThemes', '<a href="http://justfreethemes.com/oria" rel="nofollow">Oria</a>' );
}
add_action( 'oria_footer', 'oria_footer_credits' );

/**
 * Change the excerpt length
 */
function oria_excerpt_length( $length ) {
	$excerpt = get_theme_mod('exc_lenght', '35');
	return $excerpt;
}
add_filter( 'excerpt_length', 'oria_excerpt_length', 999 );

/**
 * Excerpt read more
*/
function oria_excerpt_more($more) {
    global $post;
    $read_more = get_theme_mod('read_more_text', 'Continue reading');
	return '<a class="read-more" href="'. get_permalink($post->ID) . '">' . esc_html($read_more) . '</a>';
}
add_filter('excerpt_more', 'oria_excerpt_more');

/**
 * Top bar class
*/
if ( ! function_exists( 'oria_sidebar_mode' ) ) {
	function oria_sidebar_mode() {
	    if ( is_singular() || !is_active_sidebar( 'sidebar-1' ) ) {
		echo 'no-toggle';
	    }
	}
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the slider
 */
require get_template_directory() . '/inc/slider.php';

/**
 * Styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 *TGM Plugin activation.
 */
require_once get_template_directory() . '/class-tgm-plugin-activation.php';

/**
 * TGMPA register
 */
function oria_register_required_plugins() {
		$plugins = array(
			array(
				'name'      => 'WP Product Reviews',
				'slug'      => 'wp-product-reviews',
				'required'  => false,
			),

			array(
				'name'      => 'Intergeo Maps - Google Maps Plugin',
				'slug'      => 'intergeo-maps',
				'required'  => false
			),

			array(
				'name'     => 'Pirate Forms',
				'slug' 	   => 'pirate-forms',
				'required' => false
			));

	$config = array(
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'oria' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'oria' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'oria' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'oria' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'oria' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'oria' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'oria' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'oria' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'oria' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'oria' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'oria' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'oria' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'oria' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'oria' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'oria' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'oria' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'oria' ),
            'nag_type'                        => 'updated'
        )
    );

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'oria_register_required_plugins' );
