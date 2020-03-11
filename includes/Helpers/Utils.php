<?php

namespace PowerSiteBuilder\Helpers;

class Utils {

    function __construct(){}

    public static function get_builder_content($content_id){
        $elementor_instance = \Elementor\Plugin::instance();
        return $elementor_instance->frontend->get_builder_content_for_display( $content_id );
    }

    public static function mk_class($dirname){
        $dirname = pathinfo($dirname, PATHINFO_FILENAME);
        $class_name	 = explode( '-', $dirname );
        $class_name	 = array_map( 'ucfirst', $class_name );
        $class_name	 = implode( '_', $class_name );

        return $class_name;
    }

    public static function get_option($key='power_site_builder_options', $c='widget_list', $default = ''){
        $data_all = get_option($key);

        return (isset($data_all[$c]) && $data_all[$c] != '') ? $data_all[$c] : $default;
    }
    public static function update_option($key='power_site_builder_options', $c='widget_list', $value = '', $senitize_func = 'sanitize_text_field'){
        $data_all = get_option($key);
        $value = self::sanitize($value, $senitize_func);
        $data_all[$c] = $value;
        update_option($key, $data_all);
    }
    
    public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
        $senitize_func = (in_array($senitize_func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $senitize_func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $senitize_func($value);
        }else{
            return array_map(function($inner_value) use ($senitize_func){
                return self::sanitize($inner_value, $senitize_func);
            }, $value);
        }
    }



    public static function kses($raw){
			
        $allowed_tags = [
            'a'								 => [
                'class'	 => [],
                'href'	 => [],
                'rel'	 => [],
                'title'	 => [],
            ],
            'abbr'							 => [
                'title' => [],
            ],
            'b'								 => [],
            'blockquote'					 => [
                'cite' => [],
            ],
            'cite'							 => [
                'title' => [],
            ],
            'code'							 => [],
            'del'							 => [
                'datetime'	 => [],
                'title'		 => [],
            ],
            'dd'							 => [],
            'div'							 => [
                'class'	 => [],
                'title'	 => [],
                'style'	 => [],
            ],
            'dl'							 => [],
            'dt'							 => [],
            'em'							 => [],
            'h1'							 => [
                'class' => [],
            ],
            'h2'							 => [
                'class' => [],
            ],
            'h3'							 => [
                'class' => [],
            ],
            'h4'							 => [
                'class' => [],
            ],
            'h5'							 => [
                'class' => [],
            ],
            'h6'							 => [
                'class' => [],
            ],
            'i'								 => [
                'class' => [],
            ],
            'img'							 => [
                'alt'	 => [],
                'class'	 => [],
                'height' => [],
                'src'	 => [],
                'width'	 => [],
            ],
            'li'							 => [
                'class' => [],
            ],
            'ol'							 => [
                'class' => [],
            ],
            'p'								 => [
                'class' => [],
            ],
            'q'								 => [
                'cite'	 => [],
                'title'	 => [],
            ],
            'span'							 => [
                'class'	 => [],
                'title'	 => [],
                'style'	 => [],
            ],
            'iframe'						 => [
                'width'			 => [],
                'height'		 => [],
                'scrolling'		 => [],
                'frameborder'	 => [],
                'allow'			 => [],
                'src'			 => [],
            ],
            'strike'						 => [],
            'br'							 => [],
            'strong'						 => [],
            'data-wow-duration'				 => [],
            'data-wow-delay'				 => [],
            'data-wallpaper-options'		 => [],
            'data-stellar-background-ratio'	 => [],
            'ul'							 => [
                'class' => [],
            ],
        ];
        return ( function_exists( 'wp_kses' ) ) ? wp_kses( $raw, $allowed_tags ) : $raw;
    }

}