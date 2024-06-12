<?php

/**
 * Leonardo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package TFLD Leonardo
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tfld_leonardo_setup()
{
    /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Leonardo, use a find and replace
		* to change 'tfld-leonardo' to the name of your theme in all the template files.
		*/
    load_theme_textdomain('tfld-leonardo', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
    add_theme_support('title-tag');

    /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'tfld-leonardo'),
        )
    );

    /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'tfld_leonardo_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'tfld_leonardo_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tfld_leonardo_content_width()
{
    $GLOBALS['content_width'] = apply_filters('tfld_leonardo_content_width', 640);
}
add_action('after_setup_theme', 'tfld_leonardo_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tfld_leonardo_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'tfld-leonardo'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'tfld-leonardo'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'tfld_leonardo_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function tfld_leonardo_scripts()
{
    wp_enqueue_style('tfld-leonardo-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('tfld-leonardo-style', 'rtl', 'replace');

    // wp_enqueue_script('tfld-leonardo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tfld_leonardo_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * ACF Gutenberg Blocks.
 */
require get_template_directory() . '/blocks/register-blocks.php';

/**
 * Gutenberg Category.
 */
require get_template_directory() . '/blocks/register-category.php';

/**
 * WP_ENVIRONMENT.
 */
require get_template_directory() . '/wp-env.php';

/**
 * TFLD Framework begins here
 * 
 */
// Theme dir path
if (!defined('TFLD_FRAMEWORK_DIR')) {
    define('TFLD_FRAMEWORK_DIR', untrailingslashit(get_stylesheet_directory()));
}
// Theme URL
if (!defined('TFLD_FRAMEWORK_URL')) {
    define('TFLD_FRAMEWORK_URL', untrailingslashit(get_stylesheet_directory_uri()));
}

/**
 * Abstract singleton class.
 * Could have used trait to inject the same code.
 * 
 */
include_once TFLD_FRAMEWORK_DIR . '/core/classes/abstracts/class-tfld-singleton.php';

/**
 * Trait for includin files.
 * 
 */
include_once TFLD_FRAMEWORK_DIR . '/core/traits/trait-include-files.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
if (!class_exists('TFLD_Framework', false)) {
    include_once TFLD_FRAMEWORK_DIR . '/core/classes/class-tfld-framework.php'; // Include files witout the autoloader
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * 
 */
function tfld_framework(): void
{

    TFLD\core\TFLD_Framework::get_instance();
}

tfld_framework();
