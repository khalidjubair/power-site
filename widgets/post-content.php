<?php
namespace PowerSiteBuilder\Widgets;
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class Power_Site_Builder_Post_Content extends \Elementor\Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_post_content';
		}
		
		public function get_title() {
			return __( 'Post Content', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function show_in_panel() {
			return 'post' != get_post_type();
		}
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_post_content_section',
				[
					'label' => __( 'Post Content', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_content_id',
				[
					'label'       => __( 'Other Post ID', 'power-site-builder' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'placeholder' => __( 'Type your post id here', 'power-site-builder' ),
				]
			);

			$this->end_controls_section();
			
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			extract($settings);
			echo \Power_Site_Builder\Libs\Helpers::get_builder_content($psb_post_content_id);
			
			
		}

		protected function _content_template() { }
	}