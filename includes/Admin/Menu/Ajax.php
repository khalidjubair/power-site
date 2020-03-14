<?php 
namespace PowerSiteBuilder\Admin\Menu;
use \PowerSiteBuilder\Helpers\Utils as Utils;
use \PowerSiteBuilder\Admin\WidgetsMap\Init as Widgets;

defined( 'ABSPATH' ) || exit;

class Ajax{
    public function __construct() {
        add_action( 'wp_ajax_psb_admin_action', [$this, 'admin'] );
        add_action( 'init', [$this, 'admin_init'] );
    }
    public function admin() {
        if(!current_user_can('edit_theme_options')){
            wp_die(esc_html__('Access denied.', 'power-site-builder'));
        } 
        Utils::update_option('power_site_builder_options', 'widget_list', $_POST['widget_list']);
        wp_die();
    }

    public function admin_init() {
        $default_widgets = Widgets::default_widgets(); 
        $data = get_option('power_site_builder_options');
        if(isset($data) && is_array($data['widget_list'])){
            return;
        }
        Utils::update_option('power_site_builder_options', 'widget_list', $default_widgets);

    }
}