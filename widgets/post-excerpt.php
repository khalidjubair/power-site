<?php

namespace PowerSiteBuilder;
use PowerSiteBuilder\Helpers\Utils as Utils;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class PowerSiteBuilder_Post_Excerpt extends Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_post_excerpt';
		}
		
		public function get_title() {
			return __( 'Post Excerpt', 'power-site-builder' );
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
				'psb_section_post_excerpt_section',
				[
					'label' => __( 'Post Excerpt', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_excerpt_use_custom_excerpt',
				[
					'label'        => __( 'Use Custom Excerpt?', 'power-site-builder' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Icon', 'power-site-builder' ),
					'label_off'    => __( 'Image', 'power-site-builder' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'psb_post_excerpt_custom_excerpt',
				[
					'label'       => __( 'Custom Excerpt', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Post Excerpt', 'power-site-builder' ),
					'placeholder' => __( 'Type your excerpt here', 'power-site-builder' ),
					'condition' => [
						'psb_post_excerpt_use_custom_excerpt' => 'yes',
					],
				]
			);
			$this->add_control(
				'psb_post_excerpt_word_limit',
				[
					'label'       => __( 'Limit Word', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '20',
					'placeholder' => __( 'Type your excerpt word limit', 'power-site-builder' ),
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'psb_heading_section_style',
				[
					'label' => esc_html__( 'Excerpt', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_post_excerpt_typography',
					'label'    => esc_html__( 'Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-post-excerpt',
				]
			);
			$this->add_control(
				'psb_post_excerpt_text_color',
				[
					'label'     => esc_html__( 'Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-post-excerpt' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_post_excerpt_margin',
				[
					'label'      => esc_html__( 'Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_post_excerpt_padding',
				[
					'label'      => esc_html__( 'Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-post-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_post_excerpt_text_shadow',
					'label'    => esc_html__( 'Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-post-excerpt',
				]
			);
			$this->end_controls_section();
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			extract($settings);

			$post_excerpt = $psb_post_excerpt_use_custom_excerpt == 'yes' ? $psb_post_excerpt_custom_excerpt: get_the_excerpt();
			$trimmed_content = wp_trim_words( $post_excerpt, $psb_post_excerpt_word_limit, null );
			echo '<div class="power-post-excerpt">
				'.Utils::kses($trimmed_content).'
			</div>';
		
		}

		protected function _content_template() { }
	}