<?php
	/*
	Plugin Name: Power Site Builder
	Plugin URI: https://wordpress.org/plugins/power-site-builder
	Description: Power Site Builder is an elementor supported addons.
	Version: 1.0.1
	Author: Khalid Jubair
	Author URI: https://khalidjubair.com/
	License: GPLv3 or later
    */
    
    if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly. 
    }
    
    require_once __DIR__ . '/vendor/autoload.php';
    final class PowerSiteBuilder{

        const version = '1.0.1';
        const api_url = 'http://api.wpthemebooster.com/public/';

        private function __construct() {

            $this->define_constants();
            register_activation_hook( __FILE__, [ $this, 'activate' ] );
            add_action( 'plugins_loaded', [ $this, 'init' ] );
            add_action( 'init', [ $this, 'i18n' ] );

            add_action( 'elementor/elements/categories_registered', [$this, 'widget_categories'] );

        }

        public static function instance() {

            static $instance = false;
			if ( ! $instance ) {
				$instance = new self();
			}
            return $instance;
            
		}
		
		public function i18n() {
			load_plugin_textdomain( 'power-site-builder', false, basename( dirname( __FILE__ ) ) . '/languages' );	
		}

        public function define_constants(){
            
			define('POWER_SITE_BUILDER_VERSION', self::version);
			
            define('POWER_SITE_BUILDER_MINIMUM_ELEMENTOR_VERSION','2.0.0'); 
			define('POWER_SITE_BUILDER_MINIMUM_PHP_VERSION','5.6');
			
            define('POWER_SITE_BUILDER_DIR_URL',plugin_dir_url(__FILE__));
            define('POWER_SITE_BUILDER_DIR_PATH', plugin_dir_path(__FILE__));

            define('POWER_SITE_BUILDER_INCLUDES_DIR_PATH', POWER_SITE_BUILDER_DIR_PATH.'/includes');
            define('POWER_SITE_BUILDER_ADMIN_DIR_PATH', POWER_SITE_BUILDER_INCLUDES_DIR_PATH.'/Admin');
            define('POWER_SITE_BUILDER_WIDGETS_DIR_PATH', POWER_SITE_BUILDER_DIR_PATH.'/widgets');

            define('POWER_SITE_BUILDER_WIDGETS_DIR_URL', POWER_SITE_BUILDER_DIR_URL. '/widgets');
            define('POWER_SITE_BUILDER_ASSETS_DIR_URL', POWER_SITE_BUILDER_DIR_URL. '/assets');
            
            define('POWER_SITE_BUILDER_CSS_DIR_URL', POWER_SITE_BUILDER_ASSETS_DIR_URL .'/css');
            define('POWER_SITE_BUILDER_JS_DIR_URL', POWER_SITE_BUILDER_ASSETS_DIR_URL .'/js');
            define('POWER_SITE_BUILDER_IMG_DIR_URL', POWER_SITE_BUILDER_ASSETS_DIR_URL .'/images');

            define('POWER_SITE_BUILDER_ADMIN_CSS_DIR_URL', POWER_SITE_BUILDER_CSS_DIR_URL .'/admin');
            define('POWER_SITE_BUILDER_ADMIN_JS_DIR_URL', POWER_SITE_BUILDER_JS_DIR_URL .'/admin');
            define('POWER_SITE_BUILDER_ADMIN_IMG_DIR_URL', POWER_SITE_BUILDER_IMG_DIR_URL .'/admin');

			define('POWER_SITE_BUILDER_MENU_DIR_PATH', POWER_SITE_BUILDER_ADMIN_DIR_PATH . '/Menu');
			
        }
        
        public function init(){
            if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				
				return;
			}
			
			if ( ! version_compare( ELEMENTOR_VERSION, POWER_SITE_BUILDER_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
				
				return;
			}
			
			if ( version_compare( PHP_VERSION, POWER_SITE_BUILDER_MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				
				return;
			}
			
            if( is_admin() ){
			    new PowerSiteBuilder\Admin\Init; 
			}
			new PowerSiteBuilder\Cptui\Init;
            new PowerSiteBuilder\Admin\WidgetsMap\Init;
            new PowerSiteBuilder\Frontend\Init;
        }

        public function widget_categories( $elements_manager){
			$elements_manager->add_category(
				'power-site-builder',
				[
					'title' => __( 'Power Site Builder', 'power-site-builder' ),
					'icon' => 'fa fa-plug',
				]
			);
        }
        
        public function activate(){
            $installed = get_option('power_site_builder_installed');
            if(!$installed){
                update_option( 'power_site_builder_installed', time() );
            }
            
            update_option( 'power_site_builder_version', POWER_SITE_BUILDER_VERSION );
        }
        public function admin_notice_missing_main_plugin() {
			
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			
			$message = sprintf(
				
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'power-site-builder' ),
				'<strong>' . esc_html__( 'Power Site Builder', 'power-site-builder' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'power-site-builder' ) . '</strong>'
			);
			
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			
		}
		
		public function admin_notice_minimum_elementor_version() {
			
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			
			$message = sprintf(
				
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'power-site-builder' ),
				'<strong>' . esc_html__( 'Power Site Builder', 'power-site-builder' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'power-site-builder' ) . '</strong>',
				POWER_SITE_BUILDER_MINIMUM_ELEMENTOR_VERSION
			);
			
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			
		}
		
		public function admin_notice_minimum_php_version() {
			
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			
			$message = sprintf(
				
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'power-site-builder' ),
				'<strong>' . esc_html__( 'Power Site Builder', 'power-site-builder' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'power-site-builder' ) . '</strong>',
				POWER_SITE_BUILDER_MINIMUM_PHP_VERSION
			);
			
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			
		}
    }

    function power_site_builder(){
        return PowerSiteBuilder::instance();
    }
	power_site_builder();