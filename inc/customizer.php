<?php
/**
 * Oria Theme Customizer
 *
 * @package Oria
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function oria_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_section( 'header_image' )->panel         = 'oria_header_panel';
    $wp_customize->get_section( 'title_tagline' )->priority     = '9';
    $wp_customize->get_section( 'title_tagline' )->title        = __('Site branding', 'oria');
    $wp_customize->get_section( 'title_tagline' )->panel        = 'oria_header_panel';
    $wp_customize->remove_control( 'header_textcolor' );
    $wp_customize->remove_control( 'display_header_text' );

    //Titles
    class Oria_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="margin-top:30px;border-bottom:1px solid;padding:5px;color:#111;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
    //Categories dropdown control.
    class Oria_Categories_Dropdown extends WP_Customize_Control {
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'oria' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );

            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }

    //___General___//
    $wp_customize->add_section(
        'oria_general',
        array(
            'title' => __('General', 'oria'),
            'priority' => 9,
        )
    );
    //Favicon Upload
    $wp_customize->add_setting(
        'site_favicon',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_favicon',
            array(
               'label'          => __( 'Upload your favicon', 'oria' ),
               'type'           => 'image',
               'section'        => 'oria_general',
               'settings'       => 'site_favicon',
               'priority' => 10,
            )
        )
    );
    //Disable Preloader
    $wp_customize->add_setting(
        'oria_disable_preloader',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'oria_disable_preloader',
        array(
            'type' => 'checkbox',
            'label' => esc_html__( 'Disable preloader?','oria' ),
            'section' => 'oria_general',
            'priority'    => 11,
        )
    );
    //___Header area___//
    $wp_customize->add_panel( 'oria_header_panel', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Header area', 'oria'),
    ) );
    //Logo Upload
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',

        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'oria' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'settings'       => 'site_logo',
               'priority'       => 11,
            )
        )
    );
    //Logo size
    $wp_customize->add_setting(
        'logo_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '200',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control( 'logo_size', array(
        'type'        => 'number',
        'priority'    => 12,
        'section'     => 'title_tagline',
        'label'       => __('Logo size', 'oria'),
        'description' => __('Max-width for the logo. Default 200px', 'oria'),
        'input_attrs' => array(
            'min'   => 50,
            'max'   => 600,
            'step'  => 5,
            'style' => 'margin-bottom: 15px; padding: 15px;',
        ),
    ) );
    //Logo style
    $wp_customize->add_setting(
        'logo_style',
        array(
            'default'           => 'hide-title',
            'sanitize_callback' => 'oria_sanitize_logo_style',
        )
    );
    $wp_customize->add_control(
        'logo_style',
        array(
            'type'          => 'radio',
            'label'         => __('Logo style', 'oria'),
            'description'   => __('This option applies only if you are using a logo', 'oria'),
            'section'       => 'title_tagline',
            'priority'      => 13,
            'choices'       => array(
                'hide-title'  => __( 'Only logo', 'oria' ),
                'show-title'  => __( 'Logo plus site title&amp;description', 'oria' ),
            ),
        )
    );
    //Padding
    $wp_customize->add_setting(
        'branding_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )
    );
    $wp_customize->add_control( 'branding_padding', array(
        'type'        => 'number',
        'priority'    => 14,
        'section'     => 'title_tagline',
        'label'       => __('Site branding padding', 'oria'),
        'description' => __('Top&amp;bottom padding for the branding (logo, site title, description). Default: 75px', 'oria'),
        'input_attrs' => array(
            'min'   => 20,
            'max'   => 200,
            'step'  => 5,
            'style' => 'padding: 15px;',
        ),
    ) );
    //___Carousel___//
    $wp_customize->add_section(
        'oria_carousel',
        array(
            'title' => __('Carousel', 'oria'),
            'priority' => 13,
        )
    );
    //Display: Front page
    $wp_customize->add_setting(
        'carousel_display_front',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
            'default' => 0,
        )
    );
    $wp_customize->add_control(
        'carousel_display_front',
        array(
            'type' => 'checkbox',
            'label' => __('Show carousel on front page?', 'oria'),
            'section' => 'oria_carousel',
            'priority' => 8,
        )
    );
    //Display: Home and archives
    $wp_customize->add_setting(
        'carousel_display_archives',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
            'default' => 1,
        )
    );
    $wp_customize->add_control(
        'carousel_display_archives',
        array(
            'type' => 'checkbox',
            'label' => __('Show carousel on blog index/archives/etc?', 'oria'),
            'section' => 'oria_carousel',
            'priority' => 9,
        )
    );
    //Display: Singular
    $wp_customize->add_setting(
        'carousel_display_singular',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
            'default' => 0,
        )
    );
    $wp_customize->add_control(
        'carousel_display_singular',
        array(
            'type' => 'checkbox',
            'label' => __('Show carousel on single posts and pages?', 'oria'),
            'section' => 'oria_carousel',
            'priority' => 10,
        )
    );
    //Category
    $wp_customize->add_setting( 'carousel_cat', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( new oria_Categories_Dropdown( $wp_customize, 'carousel_cat', array(
        'label'     => __('Select which category to show in the carousel', 'oria'),
        'section'   => 'oria_carousel',
        'settings'  => 'carousel_cat',
        'priority'  => 11
    ) ) );
    //Autoplay speed
    $wp_customize->add_setting(
        'carousel_speed',
        array(
            'default'           => '4000',
            'sanitize_callback' => 'oria_sanitize_int',
        )
    );
    $wp_customize->add_control(
        'carousel_speed',
        array(
            'label'     => __('Enter the carousel speed in miliseconds [Default: 4000]', 'oria'),
            'section'   => 'oria_carousel',
            'type'      => 'text',
            'priority'  => 13
        )
    );
    //Number of posts
    $wp_customize->add_setting(
        'carousel_number',
        array(
            'default'           => '6',
            'sanitize_callback' => 'oria_sanitize_int',
        )
    );
    $wp_customize->add_control(
        'carousel_number',
        array(
            'label'     => __('Enter the number of posts you want to show', 'oria'),
            'section'   => 'oria_carousel',
            'type'      => 'text',
            'priority'  => 12
        )
    );
    //___Blog options___//
    $wp_customize->add_section(
        'blog_options',
        array(
            'title' => __('Blog options', 'oria'),
            'priority' => 13,
        )
    );
    // Blog layout
    $wp_customize->add_setting('oria_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new Oria_Info( $wp_customize, 'layout', array(
        'label' => __('Layout', 'oria'),
        'section' => 'blog_options',
        'settings' => 'oria_options[info]',
        'priority' => 10
        ) )
    );
    //Full width singles
    $wp_customize->add_setting(
        'fullwidth_single',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'fullwidth_single',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width single posts?', 'oria'),
            'section'   => 'blog_options',
            'priority'  => 12,
        )
    );
    //Content/excerpt
    $wp_customize->add_setting('oria_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new Oria_Info( $wp_customize, 'content', array(
        'label' => __('Content/excerpt', 'oria'),
        'section' => 'blog_options',
        'settings' => 'oria_options[info]',
        'priority' => 13
        ) )
    );
    //Excerpt
    $wp_customize->add_setting(
        'exc_lenght',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '35',
        )
    );
    $wp_customize->add_control( 'exc_lenght', array(
        'type'        => 'number',
        'priority'    => 16,
        'section'     => 'blog_options',
        'label'       => __('Excerpt lenght', 'oria'),
        'description' => __('Excerpt length [default: 35 words]', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 5,
            'style' => 'padding: 15px;',
        ),
    ) );
    //Read more
    $wp_customize->add_setting(
        'read_more_text',
        array(
            'default'           => __('Continue reading','oria'),
            'sanitize_callback' => 'oria_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'read_more_text',
        array(
            'label'     => __('Enter the text for the Continue Reading button', 'oria'),
            'section'   => 'blog_options',
            'type'      => 'text',
            'priority'  => 17
        )
    );
    //Meta
    $wp_customize->add_setting('oria_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new Oria_Info( $wp_customize, 'meta', array(
        'label' => __('Meta', 'oria'),
        'section' => 'blog_options',
        'settings' => 'oria_options[info]',
        'priority' => 18
        ) )
    );
    //Hide meta index
    $wp_customize->add_setting(
      'hide_meta_index',
      array(
        'sanitize_callback' => 'oria_sanitize_checkbox',
        'default' => 0,
      )
    );
    $wp_customize->add_control(
      'hide_meta_index',
      array(
        'type' => 'checkbox',
        'label' => __('Hide post meta on index, archives?', 'oria'),
        'section' => 'blog_options',
        'priority' => 19,
      )
    );
    //Hide meta single
    $wp_customize->add_setting(
      'hide_meta_single',
      array(
        'sanitize_callback' => 'oria_sanitize_checkbox',
        'default' => 0,
      )
    );
    $wp_customize->add_control(
      'hide_meta_single',
      array(
        'type' => 'checkbox',
        'label' => __('Hide post meta on single posts?', 'oria'),
        'section' => 'blog_options',
        'priority' => 20,
      )
    );
    //Featured images
    $wp_customize->add_setting('oria_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control( new Oria_Info( $wp_customize, 'images', array(
        'label' => __('Featured images', 'oria'),
        'section' => 'blog_options',
        'settings' => 'oria_options[info]',
        'priority' => 21
        ) )
    );
    //Index images
    $wp_customize->add_setting(
        'index_feat_image',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'index_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Hide featured images on index, archives?', 'oria'),
            'section' => 'blog_options',
            'priority' => 22,
        )
    );
    //Post images
    $wp_customize->add_setting(
        'post_feat_image',
        array(
            'sanitize_callback' => 'oria_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'post_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Hide featured images on single posts?', 'oria'),
            'section' => 'blog_options',
            'priority' => 23,
        )
    );

    //___Fonts___//
    $wp_customize->add_section(
        'oria_fonts',
        array(
            'title' => __('Fonts', 'oria'),
            'priority' => 15,
            'description' => __('You can use any Google Fonts you want for the heading and/or body. See the fonts here: google.com/fonts. See the documentation if you need help with this: flyfreemedia.com/documentation/oria', 'oria'),
        )
    );
    //Body fonts
    $wp_customize->add_setting(
        'body_font_name',
        array(
            'default' => 'Lato:400,700,400italic,700italic',
            'sanitize_callback' => 'oria_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'body_font_name',
        array(
            'label' => __( 'Body font name/style/sets', 'oria' ),
            'section' => 'oria_fonts',
            'type' => 'text',
            'priority' => 11
        )
    );
    //Body fonts family
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'default' => 'Lato, sans-serif',
            'sanitize_callback' => 'oria_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'body_font_family',
        array(
            'label' => __( 'Body font family', 'oria' ),
            'section' => 'oria_fonts',
            'type' => 'text',
            'priority' => 12
        )
    );
    //Headings fonts
    $wp_customize->add_setting(
        'headings_font_name',
        array(
            'default' => 'Oswald:300,700',
            'sanitize_callback' => 'oria_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'headings_font_name',
        array(
            'label' => __( 'Headings font name/style/sets', 'oria' ),
            'section' => 'oria_fonts',
            'type' => 'text',
            'priority' => 14
        )
    );
    //Headings fonts family
    $wp_customize->add_setting(
        'headings_font_family',
        array(
            'default' => 'Oswald, sans-serif',
            'sanitize_callback' => 'oria_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'headings_font_family',
        array(
            'label' => __( 'Headings font family', 'oria' ),
            'section' => 'oria_fonts',
            'type' => 'text',
            'priority' => 15
        )
    );
    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '62',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'oria_fonts',
        'label'       => __('Site title', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 90,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    // Site description
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '18',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'oria_fonts',
        'label'       => __('Site description', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '38',
        )
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'oria_fonts',
        'label'       => __('H1 font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '30',
        )
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'oria_fonts',
        'label'       => __('H2 font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '24',
        )
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 19,
        'section'     => 'oria_fonts',
        'label'       => __('H3 font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '18',
        )
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 20,
        'section'     => 'oria_fonts',
        'label'       => __('H4 font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
        )
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 21,
        'section'     => 'oria_fonts',
        'label'       => __('H5 font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
        )
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 22,
        'section'     => 'oria_fonts',
        'label'       => __('H6 font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '15',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'oria_fonts',
        'label'       => __('Body font size', 'oria'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 24,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    //___Colors___//
    //Primary color
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#EF997F',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => 'Primary color',
                'section'       => 'colors',
                'settings'      => 'primary_color',
                'priority'      => 12
            )
        )
    );
    //Site title
    $wp_customize->add_setting(
        'site_title_color',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title_color',
            array(
                'label' => 'Site title',
                'section' => 'colors',
                'settings' => 'site_title_color',
                'priority' => 18
            )
        )
    );
    //Site desc
    $wp_customize->add_setting(
        'site_desc_color',
        array(
            'default'           => '#bbb',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_desc_color',
            array(
                'label' => 'Site description',
                'section' => 'colors',
                'priority' => 19
            )
        )
    );
    //Body
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => '#717376',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => 'Body text',
                'section' => 'colors',
                'settings' => 'body_text_color',
                'priority' => 22
            )
        )
    );


    //___Footer___//
    $wp_customize->add_section(
        'oria_footer',
        array(
            'title'         => __('Footer widgets', 'oria'),
            'priority'      => 18,
        )
    );
    $wp_customize->add_setting(
        'footer_widget_areas',
        array(
            'default'           => '3',
            'sanitize_callback' => 'oria_sanitize_fwidgets',
        )
    );
    $wp_customize->add_control(
        'footer_widget_areas',
        array(
            'type'        => 'radio',
            'label'       => __('Footer widget area', 'oria'),
            'section'     => 'oria_footer',
            'description' => __('Choose the number of widget areas in the footer, then go to Appearance > Widgets and add your widgets.', 'oria'),
            'choices' => array(
                '1'     => __('One', 'oria'),
                '2'     => __('Two', 'oria'),
                '3'     => __('Three', 'oria'),
            ),
        )
    );

}
add_action( 'customize_register', 'oria_customize_register' );

/**
* Sanitize
*/
//Text
function oria_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
//Checkboxes
function oria_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
// Logo style
function oria_sanitize_logo_style( $input ) {
    $valid = array(
                'hide-title'  => __( 'Only logo', 'oria' ),
                'show-title'  => __( 'Logo plus site title&amp;description', 'oria' ),
            );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Footer widget areas
function oria_sanitize_fwidgets( $input ) {
    $valid = array(
        '1'     => __('One', 'oria'),
        '2'     => __('Two', 'oria'),
        '3'     => __('Three', 'oria'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Integers
function oria_sanitize_int( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function oria_customize_preview_js() {
	wp_enqueue_script( 'oria_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'oria_customize_preview_js' );

function oria_registers() {
	wp_enqueue_script( 'oria_customizer_script', get_template_directory_uri() . '/js/oria_customizer.js', array("jquery"), '20120206', true  );

	wp_localize_script( 'oria_customizer_script', 'oriaCustomizerObject', array(
		'github'				=> __('GitHub','oria'),
		'review'				=> __('Leave a Review', 'oria')
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'oria_registers' );
