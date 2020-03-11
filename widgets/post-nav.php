<?php

namespace PowerSiteBuilder;
use PowerSiteBuilder\Helpers\Utils as Utils;

use \Elementor\Widget_Base;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class PowerSiteBuilder_Post_Nav extends Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_post_nav';
		}
		
		public function get_title() {
			return __( 'Post Nav', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_post_nav_section',
				[
					'label' => __( 'Post Nav', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_nav_prev_label',
				[
					'label'       => __( 'Prev Label', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default' => __( 'Previous Post', 'power-site-builder' ),
					'placeholder' => __( 'Previous Post ', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_nav_next_label',
				[
					'label'       => __( 'Next Label', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default' => __( 'Next Post', 'power-site-builder' ),
					'placeholder' => __( 'Next Post ', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_nav_thumb_show',
				[
					'label' => esc_html__( 'Show Thumbnail?', 'power-site-builder' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'power-site-builder' ),
					'label_off' => esc_html__( 'No', 'power-site-builder' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'psb_post_nav_fallback',
				[
					'label'     => __( 'Fallback Image', 'power-site-builder' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => '',
					],
					'condition' => [
						'psb_post_nav_thumb_show' => 'yes',
					]
				]
			);
			$this->add_control(
				'psb_post_nav_prev_thumb',
				[
					'label' => __( 'Image', 'power-site-builder' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => [
						'url' => '',
						'id' => '',
					],
					'condition' => [
						'psb_post_nav_thumb_show' => 'yes',
					]
				]
			);
			$this->add_control(
				'psb_post_nav_next_thumb',
				[
					'label' => __( 'Image', 'power-site-builder' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => [
						'url' => '',
						'id' => '',
					],
					'condition' => [
						'psb_post_nav_thumb_show' => 'yes',
					]
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name' => 'psb_post_nav_thumb_size',
					'default' => 'full',
					'separator' => 'none',
					'condition' => [
						'psb_post_nav_thumb_show' => 'yes',
					]
				]
			); 
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_post_nav_section_wrapper_style',
				[
					'label' => __( 'Wrapper', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'psb_post_nav_wrapper_bg_color',
				[
					'label'     => __( 'Background Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .power-post-nav' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'psb_post_nav_wrapper_border',
					'label'    => __( 'Border', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-post-nav',
				]
			);
			$this->add_responsive_control(
				'psb_post_nav_wrapper_radius',
				[
					'label'      => __( 'Border Radius', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-post-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'psb_post_nav_wrapper_shadow',
					'label' => __( 'Box Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-post-nav',
				]
			);
			$this->add_responsive_control(
				'psb_post_nav_wrapper_padding',
				[
					'label'      => __( 'Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-post-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_post_nav_wrapper_margin',
				[
					'label'      => __( 'Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-post-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			
			$this->start_controls_section(
				'psb_post_nav_label_section_style',
				[
					'label' => esc_html__( 'Post Nav Label', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_post_nav_label_typography',
					'label'    => esc_html__( 'Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-post-nav .power-post-block .power-link-to',
				]
			);
			$this->add_control(
				'psb_post_nav_label_color',
				[
					'label'     => esc_html__( 'Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-post-nav .power-post-block .power-link-to' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_post_nav_title_section_style',
				[
					'label' => esc_html__( 'Post Title', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_post_nav_title_typography',
					'label'    => esc_html__( 'Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-post-nav .power-post-block h4 a',
				]
			);
			$this->start_controls_tabs( 'psb_post_nav_title_tabs' );
			
			$this->start_controls_tab(
				'psb_post_nav_title_tabs_normal',
				[
					'label' => __( 'Normal', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_nav_title_color_normal',
				[
					'label'     => esc_html__( 'Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-post-nav .power-post-block h4 a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'psb_post_nav_title_tabs_hover',
				[
					'label' => __( 'Hover', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_post_nav_title_color_hover',
				[
					'label'     => esc_html__( 'Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-post-nav .power-post-block h4 a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_section();
			
			$this->start_controls_section(
				'psb_post_nav_thumb_section_style',
				[
					'label' => esc_html__( 'Post Thumb', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'psb_post_nav_thumb_spacing',
				[
					'label'   => __( 'Spacing', 'power-site-builder' ),
					'type'    => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 30,
					],
					'selectors' => [
						'{{WRAPPER}} .power-post-nav .power-prev-post .power-post-block .power-post-thumb' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .power-post-nav .power-next-post .power-post-block .power-post-thumb' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}
		
		protected function render( ){
			$settings = $this->get_settings_for_display();
			extract($settings);

			$prev_image_html = $psb_post_nav_thumb_show == 'yes' ? 
				$psb_post_nav_prev_thumb['url'] != '' ?
					Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_post_nav_thumb_size', 'psb_post_nav_prev_thumb' ) : 
					Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_post_nav_thumb_size', 'psb_post_nav_fallback' ) : '';
			$next_image_html = $psb_post_nav_thumb_show == 'yes' ? 
				$psb_post_nav_next_thumb['url'] != '' ?
					Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_post_nav_thumb_size', 'psb_post_nav_next_thumb' ) : 
					Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_post_nav_thumb_size', 'psb_post_nav_fallback' ) : '';

			$next_post	 = get_next_post();
			$pre_post	 = get_previous_post();
			if ( !$next_post && !$pre_post ) {
				return;
			} ?>
			<div class="psb-wrapper">
				<div class="power-post-nav">
					<div class="row">
						<?php if ( !empty( $pre_post ) ): ?>
							<div class="col-md-6">
								<div class="power-prev-post">
									<div class="power-post-block">
										<div class="power-post-thumb">
											<a href="<?php echo get_the_permalink( $pre_post->ID ); ?>"><?php echo Utils::kses($prev_image_html); ?>
										</div>
										<div class="power-post-title">
											<a class="power-link-to" href="<?php echo get_the_permalink( $pre_post->ID ); ?>"><?php echo esc_html( $psb_post_nav_prev_label ) ?></a>
											<h4><a href="<?php echo get_the_permalink( $pre_post->ID ); ?>"><?php echo get_the_title( $pre_post->ID ) ?></a></h4>
										</div>
									</div>
								</div>
							</div>
						<?php endif; 

						if ( !empty( $next_post ) ): ?>
							<div class="col-md-6">
								<div class="power-next-post">
									<div class="power-post-block">
										<div class="power-post-thumb">
											<a href="<?php echo get_the_permalink( $next_post->ID ); ?>"><?php echo Utils::kses($next_image_html); ?>
										</div>
										<div class="power-post-title">
											<a class="power-link-to" href="<?php echo get_the_permalink( $next_post->ID ); ?>"><?php echo esc_html( $psb_post_nav_next_label) ?></a>
											<h4><a href="<?php echo get_the_permalink( $next_post->ID ); ?>"><?php echo get_the_title( $next_post->ID ) ?></a></h4>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div><?php
			
		}

		protected function _content_template() { }
	}