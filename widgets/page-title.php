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
	
	class PowerSiteBuilder_Page_Title extends Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_page_title';
		}
		
		public function get_title() {
			return __( 'Page Title', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function show_in_panel() {
			return 'page' == get_post_type();
		}
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_page_title_section',
				[
					'label' => __( 'Page Title', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_page_title_use_custom_title',
				[
					'label'        => __( 'Use Custom Title?', 'power-site-builder' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'power-site-builder' ),
					'label_off'    => __( 'No', 'power-site-builder' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'psb_page_title_custom_title',
				[
					'label'       => __( 'Custom Title', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Page Title', 'power-site-builder' ),
					'placeholder' => __( 'Type your title here', 'power-site-builder' ),
					'condition' => [
						'psb_page_title_use_custom_title' => 'yes',
					],
				]
			);

			$this->add_control(
				'psb_page_title_tag',
				[
					'label' => esc_html__( 'Title HTML Tag', 'elementskit' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
						'div' => 'div',
						'span' => 'span',
						'p' => 'p',
					],
					'default' => 'h2',
				]
			);

			$this->add_responsive_control(
				'psb_page_title_align',
				[
					'label'        => __( 'Alignment', 'power-site-builder' ),
					'type'         => Controls_Manager::CHOOSE,
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
					'name'     => 'psb_page_title_typography',
					'label'    => esc_html__( 'Title Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-page-title',
				]
			);
			$this->add_control(
				'psb_page_title_text_color',
				[
					'label'     => esc_html__( 'Title Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-page-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_page_title_margin',
				[
					'label'      => esc_html__( 'Title Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-page-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_page_title_padding',
				[
					'label'      => esc_html__( 'Title Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-page-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_page_title_text_shadow',
					'label'    => esc_html__( 'Title Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-page-title',
				]
			);
			$this->end_controls_section();
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			extract($settings);
			$page_title = $psb_page_title_use_custom_title == 'yes' ? $psb_page_title_custom_title : get_the_title();
			
			echo '<'.$psb_page_title_tag.' class="power-page-title">
				'.Utils::kses($page_title).'
			</'.$psb_page_title_tag.'>';
		
		}

		protected function _content_template() { }
	}