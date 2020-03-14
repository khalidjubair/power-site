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
	
	class PowerSiteBuilder_Search_Form extends Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_search_form';
		}
		
		public function get_title() {
			return __( 'Search Form', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_search_form_section',
				[
					'label' => __( 'Search Form', 'power-site-builder' ),
				]
			);
			
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_heading_section_style',
				[
					'label' => esc_html__( 'Title', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_search_form_typography',
					'label'    => esc_html__( 'Title Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-search-form',
				]
			);
			$this->add_control(
				'psb_search_form_text_color',
				[
					'label'     => esc_html__( 'Title Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-search-form' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_search_form_margin',
				[
					'label'      => esc_html__( 'Title Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-search-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_search_form_padding',
				[
					'label'      => esc_html__( 'Title Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_search_form_text_shadow',
					'label'    => esc_html__( 'Title Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-search-form',
				]
			);
			$this->end_controls_section();
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			extract($settings);
			$search_form = $psb_search_form_use_custom_title == 'yes' ? $psb_search_form_custom_title : get_the_title();
			
			$form = '
				<form method="get" action="' . esc_url( home_url( '/' ) ) . '">
					<input type="text" name="s" class="keyword form-control" placeholder="' .esc_attr__( 'Search', 'power' ) . '" value="' . get_search_query() . '">
					<button type="submit" class="power-form-control power-form-control-submit"><i class="fa fa-search"></i></button>
				</form>';


			echo '<div class="power-search-form">
				'.Utils::kses($form).'
			</div>';
		
		}

		protected function _content_template() { }
	}