<?php
namespace PowerSiteBuilder\Admin;

defined( 'ABSPATH' ) || die();

class Init { 
    private static $page_slug	 = 'power-site-builder-dashboard';
    static $menu_slug = '';

    public function __construct() {
            
        add_action( 'admin_menu', [ __CLASS__, 'add_menu' ], 21 );
        add_action( 'admin_menu', [ __CLASS__, 'update_menu_items' ], 99 );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
         
    }
    
    public static function enqueue_scripts( $hook ) {
        if ( self::$menu_slug !== $hook || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        wp_enqueue_style(
            'power-site-builder-framework',
            POWER_SITE_BUILDER_ASSETS . '/css/libraries.css', 
            null,
            '1.0'
        );
        
        wp_enqueue_style(
            'power-site-builder-font-awesome',
            POWER_SITE_BUILDER_ASSETS . '/css/admin/font-awesome.min.css',
            null,
            '1.0'
        );
        wp_enqueue_style(
            'power-site-builder-admin',
            POWER_SITE_BUILDER_ASSETS . '/css/admin/admin.css',
            null,
            '1.0'
        );
        wp_enqueue_script(
            'power-site-builder-dashboard-bootstrap',
            POWER_SITE_BUILDER_ASSETS . '/js/admin/bootstrap.js',
            [ 'jquery' ],
            '1.0',
            true
        );
        wp_enqueue_script(
            'power-site-builder-admin',
            POWER_SITE_BUILDER_ASSETS . '/js/admin/admin.js',
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
            [ __CLASS__, 'render_main' ],
            POWER_SITE_BUILDER_ASSETS .'/images/fav.png',
            2
        );
        add_submenu_page(
            self::$page_slug,
            sprintf( __( '%s - Power Site Builder Elementor Addons', 'power-site-builder' ), 'Widgets' ),
            'Widgets',
            'manage_options',
            self::$page_slug . '&admin_tab=widgets',
            [ __CLASS__, 'render_widgets' ]
        );

    }
    public static function update_menu_items() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        global $submenu;
        $menu = $submenu[ self::$page_slug ];
        array_shift( $menu );
        $submenu[ self::$page_slug ] = $menu;
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

        $file = POWER_SITE_BUILDER_PATH . '/includes/Admin/view/' . $template . '.php';
        
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
