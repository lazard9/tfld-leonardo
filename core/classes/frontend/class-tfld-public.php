<?php defined('WPINC') or die();

/**
 * The public-facing functionality of the plugin.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\core\Frontend;

use TFLD\core\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Public', false)) : class TFLD_Public extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {

            // load class.
            $this->setup_hooks();
        }

        public function setup_hooks(): void
        {

            add_action('wp_enqueue_scripts', [$this, 'tfld_enqueue_frontend_assets']);
            add_action('enqueue_block_editor_assets', [$this, 'tfld_enqueue_frontend_assets']);
        }

        /**
         * Register frontend assets for the public-facing side of the site.
         *
         */
        public function tfld_enqueue_frontend_assets(): void
        {

            /**
             * Check if Swiper plugin is active,
             * to prevent double loading of the same resources.
             * 
             */
            if (!is_plugin_active('wp-swiper/wp-swiper.php')) {

                wp_enqueue_style(
                    "tfld-framework-swiper-bundle",
                    TFLD_FRAMEWORK_URL . '/assets/build/vendor/swiper/css/swiper-bundle.min.css',
                    [],
                    '1.0.0'
                );

                wp_enqueue_script(
                    "tfld-framework-swiper-bundle",
                    TFLD_FRAMEWORK_URL . '/assets/build/vendor/swiper/js/swiper-bundle.min.js',
                    NULL,
                    '1.0.0',
                    true
                );
            }


            /**
             * DevServer is enabled on localhost:9000
             * To start the server, run: npm run serve
             * 
             * Scripts and styles are loaded based on whether npm run serve is running
             * and the environment variable is set to 'development'.
             * Always run npm run dev for development 
             * and npm run prod for production.
             */

            /**
             * Checks if a URL is available.
             *
             * @param string $url The URL to check.
             * @return bool True if the URL is available, false otherwise.
             */
            function is_url_available($url) {
                $headers = @get_headers($url);
                return $headers && strpos($headers[0], '200') !== false;
            }
            
            $environment = defined('WP_ENVIRONMENT') ? WP_ENVIRONMENT : 'production';
            $is_dev_server_running = null;

            if ($environment !== "production") {
                $url = "http://localhost:9000/js/frontend.bundle.js";
                $is_dev_server_running = is_url_available($url);
            }
            
            if ($is_dev_server_running) {
                wp_enqueue_style(
                    "tfld-framework-frontend-style",
                    "http://localhost:9000/css/frontend.css",
                    [],
                    '1.0.0'
                );
                wp_enqueue_script(
                    "tfld-framework-frontend-script",
                    "http://localhost:9000/js/frontend.bundle.js",
                    ['jquery'],
                    '1.0.0',
                    true
                );
            } else {
                wp_enqueue_style(
                    "tfld-framework-frontend-style",
                    TFLD_FRAMEWORK_URL . '/assets/build/css/frontend.css',
                    [],
                    '1.0.0'
                );
                wp_enqueue_script(
                    "tfld-framework-frontend-script",
                    TFLD_FRAMEWORK_URL . '/assets/build/js/frontend.bundle.js',
                    ['jquery'],
                    '1.0.0',
                    true
                );
            }            
        }
    }
endif;
