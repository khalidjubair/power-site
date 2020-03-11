<?php

namespace PowerSiteBuilder;
use PowerSiteBuilder\Helpers\Utils as Utils;


use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class PowerSiteBuilder_Breadcrumb extends Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_breadcrumb';
		}
		
		public function get_title() {
			return __( 'Breadcrumb', 'power-site-builder' );
		}
		
		public function get_icon() {
			return 'eicon-button';
		}
		
		public function get_categories() {
			return [ 'power-site-builder' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'psb_section_breadcrumb_section',
				[
					'label' => __( 'Breadcrumb', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_breadcrumb_home_text',
				[
					'label'       => __( 'Home Text', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default' => __( 'Home', 'power-site-builder' ),
					'placeholder' => __( 'Blog for ', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_breadcrumb_archive_prefix',
				[
					'label'       => __( 'Archive Prefix', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default' => __( 'Blog for ', 'power-site-builder' ),
					'placeholder' => __( 'Blog for ', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_breadcrumb_seperator',
				[
					'label'       => __( 'Seperator', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default' =>'/',
					'placeholder' => __( 'Seperator ', 'power-site-builder' ),
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'psb_breadcrumb_section_style',
				[
					'label' => esc_html__( 'Breadcrumb', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_breadcrumb_link_typography',
					'label'    => esc_html__( 'Link Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-breadcrumb li a',
				]
			);
			$this->add_control(
				'psb_breadcrumb_text_color',
				[
					'label'     => esc_html__( 'Link Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-breadcrumb li a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_breadcrumb_active_typography',
					'label'    => esc_html__( 'Active Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-breadcrumb li',
				]
			);
			$this->add_control(
				'psb_breadcrumb_active_color',
				[
					'label'     => esc_html__( 'Active Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-breadcrumb li' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_breadcrumb_seperator_typography',
					'label'    => esc_html__( 'Seperator Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-breadcrumb .power-sep',
				]
			);
			$this->add_control(
				'psb_breadcrumb_seperator_color',
				[
					'label'     => esc_html__( 'Seperator Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-breadcrumb .power-sep' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}
		
		protected function render( ){
			$settings = $this->get_settings_for_display();
			extract($settings);
			$seperator = Utils::kses('<span class="power-sep">'.$psb_breadcrumb_seperator.'</span>');
			echo '<ul class="power-breadcrumb">';
			if ( !is_home() ) { 
				echo '<li><a href="';
				echo esc_url( get_home_url( $psb_breadcrumb_seperator ) );
				echo '">';
				echo $psb_breadcrumb_home_text;
				echo "</a></li> " . $seperator;
				if ( is_category() || is_single() ) {
					echo '<li>';
					$category	 = get_the_category();
					$post		 = get_queried_object();
					$postType	 = get_post_type_object( get_post_type( $post ) );
					if ( !empty( $category ) ) {
						echo esc_html( $category[ 0 ]->cat_name ) . '</li>';
					} else if ( $postType ) {
						echo esc_html( $postType->labels->singular_name ) . '</li>';
					}
	
					if ( is_single() ) {
						echo $seperator . "  <li>";
						echo wp_trim_words( get_the_title() );
						echo '</li>';
					}
				} elseif ( is_page() ) {
					echo '<li>';
					echo wp_trim_words( get_the_title());
					echo '</li>';
				}
			
				if ( is_tag() ) {
					single_tag_title();
				} elseif ( is_day() ) {
					echo"<li>" . $psb_breadcrumb_archive_prefix . " ";
					the_time( 'F jS, Y' );
					echo'</li>';
				} elseif ( is_month() ) {
					echo"<li>" . $psb_breadcrumb_archive_prefix . " ";
					the_time( 'F, Y' );
					echo'</li>';
				} elseif ( is_year() ) {
					echo"<li>" . $psb_breadcrumb_archive_prefix . " ";
					the_time( 'Y' );
					echo'</li>';
				} elseif ( is_author() ) {
					echo"<li>" . $psb_breadcrumb_archive_prefix;
					echo'</li>';
				} elseif ( isset( $_GET[ 'paged' ] ) && !empty( $_GET[ 'paged' ] ) ) {
					echo "<li>" . $psb_breadcrumb_archive_prefix;
					echo'</li>';
				} elseif ( is_search() ) {
					echo"<li>" . $psb_breadcrumb_archive_prefix;
					echo'</li>';
				} elseif ( is_404() ) {
					echo"<li>" . $psb_breadcrumb_archive_prefix;
					echo'</li>';
				}
				echo '</ul>';
			}
		}

		protected function _content_template() { }
	}