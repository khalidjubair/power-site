<?php
namespace PowerSiteBuilder\Widgets;
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class Power_Site_Builder_Post_Featured_Image extends \Elementor\Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_post_featured_image';
		}
		
		public function get_title() {
			return __( 'Post Featured Image', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function show_in_panel() {
			return 'page' != get_post_type();
		}
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_post_featured_image_section',
				[
					'label' => __( 'Post Featured Image', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_featured_image_fallback',
				[
					'label'     => __( 'Fallback Image', 'power-site-builder' ),
					'type'      => \Elementor\Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => '',
					],
				]
			);
			$this->add_control(
				'psb_post_featured_image',
				[
					'label' => __( 'Image', 'power-site-builder' ),
					'type' => \Elementor\Controls_Manager::HIDDEN,
					'default' => [
						'url' => get_the_post_thumbnail_url(get_the_ID()),
						'id' => get_post_thumbnail_id(get_the_ID()),
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'psb_post_featured_image_size',
					'default' => 'full',
					'separator' => 'none',
				]
			); 
			$this->add_responsive_control(
				'psb_post_featured_image_align',
				[
					'label'        => __( 'Alignment', 'power-site-builder' ),
					'type'         => \Elementor\Controls_Manager::CHOOSE,
					'options'      => [
						'left'    => [
							'title' => __( 'Left', 'power-site-builder' ),
							'icon'  => 'fa fa-align-left',
						],
						'center'  => [
							'title' => __( 'Center', 'power-site-builder' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'   => [
							'title' => __( 'Right', 'power-site-builder' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'prefix_class' => 'elementor%s-align-',
					'default'      => '',
				]
			);
			
			$this->end_controls_section();
			$this->end_controls_section();
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			extract($settings);
			$image_html = $psb_post_featured_image['url'] != '' ?
				\Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_post_featured_image_size', 'psb_post_featured_image' ) : 
				\Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_post_featured_image_size', 'psb_post_featured_image_fallback' );;

			echo '<div class="power-post-featured-image">
				'.\Power_Site_Builder\Libs\Helpers::kses($image_html).'
			</div>';
		
		}

		protected function _content_template() { }
	}