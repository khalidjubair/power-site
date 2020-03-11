<?php
namespace PowerSiteBuilder\Admin\Menu;

defined( 'ABSPATH' ) || die();

class Init { 
    private static $page_slug	 = 'power-site-builder-dashboard';
    static $menu_slug = '';

    public function __construct() {
            
        add_action( 'admin_menu', [ __CLASS__, 'add_menu' ], 21 );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
         
    }
    
    public static function enqueue_scripts( $hook ) {
        if ( self::$menu_slug !== $hook || ! current_user_can( 'manage_options' ) ) {
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

    }
    public static function add_menu() {
        self::$menu_slug = add_menu_page(
            __( 'Power Site Builder Dashboard', 'power-site-builder' ),
            __( 'Power Site Builder', 'power-site-builder' ),
            'manage_options',
            self::$page_slug,
            [ __CLASS__, 'render_widgets' ],
            POWER_SITE_BUILDER_IMG_DIR_URL .'/fav.png',
            2
        );
    }
    public static function get_tabs() {
        $tabs = [
            'widgets' => [
                'title' => esc_html__( 'Widgets', 'power-site-builder' ),
                'render' => [ __CLASS__, 'render_widgets' ]
            ],
        ];

        return apply_filters( 'psb_dashboard_get_tabs', $tabs ); 
    }

    private static function load_template( $template ) { 

        $file = POWER_SITE_BUILDER_MENU_DIR_PATH . '/view/' . $template . '.php';
        if ( is_readable( $file ) ) {
            include( $file );
        }
        
    }

    public static function render_main() {
        self::load_template( 'main' );
    }
    public static function render_widgets() {
        self::load_template( 'widgets' );
    }
    public static function render_tabs($template) {
        self::load_template( $template );
    }
}
