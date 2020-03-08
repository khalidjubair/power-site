<?php
namespace PowerSiteBuilder\Widgets;
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class Power_Site_Builder_Comments extends \Elementor\Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_comments';
		}
		
		public function get_title() {
			return __( 'Comments', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_comments_section',
				[
					'label' => __( 'Comments', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_comments_text',
				[
					'label'       => __( 'Text', 'power-site-builder' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Home', 'power-site-builder' ),
					'placeholder' => __( 'Blog for ', 'power-site-builder' ),
				]
			);

			$this->end_controls_section();
		}
		
		protected function render( ){
			$settings = $this->get_settings_for_display();
			extract($settings);

			Libs\Helpers::comments(); 
			
		}

		protected function _content_template() { }
	}