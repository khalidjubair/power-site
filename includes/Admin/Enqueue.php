<?php
namespace PowerSiteBuilder\Admin;

defined( 'ABSPATH' ) || die();

class Enqueue { 

    public function __construct() {

        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_enqueue_scripts' ] );
         
    }
    
    public static function admin_enqueue_scripts( $hook ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        wp_enqueue_style( 
            'power-site-builder-framework',
            POWER_SITE_BUILDER_CSS_DIR_URL . '/libraries.min.css', 
            null,
            '1.0'
        );
        
        wp_enqueue_style(
            'power-site-builder-font-awesome',
            POWER_SITE_BUILDER_ADMIN_CSS_DIR_URL . '/font-awesome.min.css',
            null,
            '1.0'
        );
        wp_enqueue_style(
            'power-site-builder-admin',
            POWER_SITE_BUILDER_ADMIN_CSS_DIR_URL . '/admin.min.css',
            null,
            '1.0'
        );
        wp_enqueue_style(
            'power-site-builder-dashboard',
            POWER_SITE_BUILDER_ADMIN_CSS_DIR_URL . '/dashboard.min.css',
            null,
            '1.0'
        );

        wp_enqueue_script(
            'power-site-builder-dashboard-bootstrap',
            POWER_SITE_BUILDER_ADMIN_JS_DIR_URL . '/bootstrap.min.js',
            [ 'jquery' ],
            '1.0',
            true
        );

        wp_enqueue_script(
            'power-site-builder-admin',
            POWER_SITE_BUILDER_ADMIN_JS_DIR_URL . '/admin.min.js',
            [ 'jquery' ],
            '1.0',
            true
        );

        wp_enqueue_script(
            'power-site-builder-dashboard',
            POWER_SITE_BUILDER_ADMIN_JS_DIR_URL . '/dashboard.min.js',
            [ 'jquery' ],
            '1.0',
            true
        );

    }
}
