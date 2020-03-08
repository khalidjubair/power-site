<?php
	/*
	Plugin Name: Power Site Builder
	Plugin URI: https://wordpress.org/plugins/power-site-builder
	Description: Power Site Builder is an elementor supported addons.
	Version: 1.0.0
	Author: Khalid Jubair
	Author URI: https://khalidjubair.com/
	License: GPLv3 or later
    */
    
    if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly. 
    }
    
    require_once __DIR__ . '/vendor/autoload.php';
    final class PowerSiteBuilder{

        const version = '1.0';

        private function __construct() {
            $this->define_constants();
            register_activation_hook( __FILE__, [ $this, 'activate' ] );
            add_action( 'plugins_loaded', [ $this, 'init' ] );


            add_action( 'elementor/elements/categories_registered', [$this, 'widget_categories'] );

        }

        public static function instance() {

            static $instance = false;
			if ( ! $instance ) {
				$instance = new self();
			}
            return $instance;
            
        }

        public function define_constants(){
            define('POWER_SITE_BUILDER_VERSION', self::version);
            define('POWER_SITE_BUILDER_FILE', __FILE__);
            define('POWER_SITE_BUILDER_PATH', __DIR__);
            define('POWER_SITE_BUILDER_URL', plugins_url('', POWER_SITE_BUILDER_FILE));
            define('POWER_SITE_BUILDER_ASSETS', POWER_SITE_BUILDER_URL . '/assets');
            define('POWER_SITE_BUILDER_WIDGETS', POWER_SITE_BUILDER_PATH . '/widgets/');
        }
        

        public function init(){
            new PowerSiteBuilder\Admin\Widgets;
            if( is_admin() ){
                new PowerSiteBuilder\Admin();
			    new PowerSiteBuilder\Admin\Ajax;
            }else{
                new PowerSiteBuilder\Frontend();
            }
            
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
    }

    function power_site_builder(){
        return PowerSiteBuilder::instance();
    }
    power_site_builder();