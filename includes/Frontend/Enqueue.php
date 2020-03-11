<?php
namespace PowerSiteBuilder\Frontend;

defined( 'ABSPATH' ) || die();

class Enqueue { 

    public function __construct() {
        add_action( 'elementor/frontend/after_register_styles', [$this, 'widget_register_styles']);
        add_action( 'wp_enqueue_scripts', [$this, 'widget_enqueue_styles']);
        add_action( 'elementor/editor/after_enqueue_styles', [$this, 'widget_enqueue_styles']);
        add_action( 'elementor/preview/enqueue_styles', [$this, 'widget_enqueue_styles']);
    
        add_action( 'elementor/frontend/after_enqueue_scripts', [$this, 'widget_script'] );
        add_action( 'elementor/editor/after_enqueue_styles', [$this, 'editor_enqueue_styles' ] );
         
    }
    
    public function layouts_scripts(){
        wp_enqueue_script( 
            'power-modal-editor-script', 
            POWER_SITE_BUILDER_LAYOUT_JS_DIR_URL . '/editor.min.js', 
            array('jquery', 'underscore', 'backbone-marionette'), 
            POWER_SITE_BUILDER_VERSION,
            true
        );
    }

    public function widget_register_styles() {
        wp_register_style( 'power-site-builder-libraries',  
            POWER_SITE_BUILDER_CSS_DIR_URL . '/libraries.min.css');
        wp_register_style( 'power-site-builder-widgets', 
            POWER_SITE_BUILDER_CSS_DIR_URL . '/widgets.min.css' );
    } 
    public function widget_enqueue_styles() {
        wp_enqueue_style( 'power-site-builder-libraries' );
        wp_enqueue_style( 'power-site-builder-widgets' );
    } 
    
    public function editor_enqueue_styles() {
        wp_register_style( 'power-site-builder-widgets-panel', 
            POWER_SITE_BUILDER_ADMIN_CSS_DIR_URL . '/panel.min.css' );
        wp_enqueue_style( 'power-site-builder-widgets-panel' );
    }
    public function widget_script() {
        wp_enqueue_script( 'power-site-builder-libraries', 
            POWER_SITE_BUILDER_JS_DIR_URL . '/libraries.min.js',
            [ 'jquery'],
            false,
            false 
        );
        wp_enqueue_script( 'power-site-builder-widgets',
            POWER_SITE_BUILDER_JS_DIR_URL . '/widgets.min.js',
            [ 'jquery'],
            '1.0',
            true
        );
    }
}
