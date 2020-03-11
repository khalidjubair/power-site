<?php

namespace PowerSiteBuilder\Admin\WidgetsMap;
use \PowerSiteBuilder\Helpers\Utils as Utils;

class Init{

    function __construct(){
        add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widget'], 10, 1 );
    }

    public function register_widget($widgets_manager){
        $default_widgets = self::default_widgets();
        $active_widgets = self::active_widgets();
        
        foreach($active_widgets as $widget){
            if(in_array($widget, $default_widgets)){
                $class_name = 'PowerSiteBuilder\PowerSiteBuilder_' . Utils::mk_class($widget);
                include POWER_SITE_BUILDER_WIDGETS_DIR_PATH . '/' . $widget . '.php'; 
                if(class_exists($class_name)){
                    $widgets_manager->register_widget_type(new $class_name());
                }
            }
        }
    }

    public static function widgets_map(){
        return [
            'post-title' => [
                'demo' => '',
                'title' => __( 'Post Title', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'post-excerpt' => [
                'demo' => '',
                'title' => __( 'Post Excerpt', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'post-content' => [
                'demo' => '',
                'title' => __( 'Post Content', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'post-nav' => [
                'demo' => '',
                'title' => __( 'Post Nav', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'post-featured-image' => [
                'demo' => '',
                'title' => __( 'Post Featured Image', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'author-info' => [
                'demo' => '',
                'title' => __( 'Author Info', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'breadcrumb' => [
                'demo' => '',
                'title' => __( 'Breadcrumb', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'comments' => [
                'demo' => '',
                'title' => __( 'Breadcrumb', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
            'page-title' => [
                'demo' => '',
                'title' => __( 'Page Title', 'power-site-builder' ),
                'icon' => 'eicon-button',
            ],
        ];
    }
    
    public static function default_widgets(){
        $map = self::widgets_map();
        $dynamic_widgets = [];
        foreach($map as $key=>$value){
            $dynamic_widgets[] = $key;
        }
        return $dynamic_widgets;
    }
    public static function active_widgets($default=[]){
        return Utils::get_option('power_site_builder_options', 'widget_list', $default);
    }

}