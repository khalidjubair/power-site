<?php
namespace PowerSiteBuilder\Cptui;
use \PowerSiteBuilder\Helpers\Utils as Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 
class Shortcode {

	public function __construct() {
		$this->add_actions();
	}

	public function admin_columns_headers( $defaults ) {
		$defaults['shortcode'] = __( 'Shortcode', 'power-site-builder' );

		return $defaults;
	}

	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'shortcode' === $column_name ) {
			$shortcode = esc_attr( sprintf( '[%s id="%d"]', 'power-block', $post_id ) );
			printf( '<input class="power-shortcode-input" type="text" readonly onfocus="this.select()" value="%s" />', $shortcode );
		}
	}

	public function shortcode( $attributes = [] ) {
		if ( empty( $attributes['id'] ) ) {
			return '';
		}

		return Utils::get_builder_content($attributes['id']);
	} 

	private function add_actions() {
		if ( is_admin() ) {
			add_action( 'manage_psb_block_posts_columns', [ $this, 'admin_columns_headers' ] );
			add_action( 'manage_psb_block_posts_custom_column', [ $this, 'admin_columns_content' ], 10, 2 );
			add_action( 'manage_psb_nested_posts_columns', [ $this, 'admin_columns_headers' ] );
			add_action( 'manage_psb_nested_posts_custom_column', [ $this, 'admin_columns_content' ], 10, 2 );
		}

		add_shortcode( 'power-block', [ $this, 'shortcode' ] );
	}
}
