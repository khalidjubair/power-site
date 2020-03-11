<?php
namespace PowerSiteBuilder;
use PowerSiteBuilder\Helpers\Utils as Utils;

use \Elementor\Widget_Base;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	class PowerSiteBuilder_Author_Info extends Widget_Base {
		
		public function get_name() {
			return 'power_site_builder_author_info';
		}
		
		public function get_title() {
			return __( 'Author Info', 'power-site-builder' );
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
				'psb_section_author_info_section',
				[
					'label' => __( 'Author Info', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_author_info_use_custom_author',
				[
					'label'        => __( 'Use Custom Author?', 'power-site-builder' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'power-site-builder' ),
					'label_off'    => __( 'No', 'power-site-builder' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'psb_author_info_name_prefix',
				[
					'label'       => __( 'Author Prefix', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'By:', 'power-site-builder' ),
					'placeholder' => __( 'By:', 'power-site-builder' ),
				]
			);

			$this->add_control(
				'psb_author_info_avater_size',
				[
					'label'       => __( 'Avater Size', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '96',
					'placeholder' => __( 'Avater size here', 'power-site-builder' ),
				]
			);
			$this->add_responsive_control(
				'psb_author_info_align',
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
				'psb_section_author_info_custon_section',
				[
					'label' => __( 'Custom Author Info', 'power-site-builder' ),
					'condition' => [
						'psb_author_info_use_custom_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'psb_author_info_custom_avater',
				[
					'label'     => __( 'Author Image', 'power-site-builder' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name' => 'psb_author_info_custom_avater_size',
					'default' => 'small',
					'separator' => 'none',
				]
			); 
			$this->add_control(
				'psb_author_info_custom_name',
				[
					'label'       => __( 'Author Name', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'John Doe', 'power-site-builder' ),
					'placeholder' => __( 'Type Author Name', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_author_info_custom_bio',
				[
					'label'       => __( 'Author Bio', 'power-site-builder' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'power-site-builder' ),
					'placeholder' => __( 'Type Author Bio', 'power-site-builder' ),
				]
			);
			$this->add_control(
				'psb_author_info_custom_archive_url',
				[
					'label'       => __( 'Archive Link', 'power-site-builder' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'https://your-link.com', 'power-site-builder' ),
					'default'     => [
						'url' => '#',
					],
				]
			);
			
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_author_info_name_section',
				[
					'label' => esc_html__( 'Name', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_author_info_name_typography',
					'label'    => esc_html__( 'Title Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info a',
				]
			);
			$this->add_control(
				'psb_author_info_name_text_color',
				[
					'label'     => esc_html__( 'Title Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-author-info a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_name_margin',
				[
					'label'      => esc_html__( 'Title Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_name_padding',
				[
					'label'      => esc_html__( 'Title Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_author_info_name_text_shadow',
					'label'    => esc_html__( 'Title Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info a',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_author_info_name_prefix_section',
				[
					'label' => esc_html__( 'Name Prefix', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_author_info_name_prefix_typography',
					'label'    => esc_html__( 'Title Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info .power-author-prefix',
				]
			);
			$this->add_control(
				'psb_author_info_name_prefix_text_color',
				[
					'label'     => esc_html__( 'Title Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-author-info .power-author-prefix' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_name_prefix_margin',
				[
					'label'      => esc_html__( 'Title Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info .power-author-prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_name_prefix_padding',
				[
					'label'      => esc_html__( 'Title Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info .power-author-prefix' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_author_info_name_prefix_text_shadow',
					'label'    => esc_html__( 'Title Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info .power-author-prefix',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_author_info_bio_section',
				[
					'label' => esc_html__( 'Biograph', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_author_info_bio_typography',
					'label'    => esc_html__( 'Title Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info .power-author-bio',
				]
			);
			$this->add_control(
				'psb_author_info_bio_text_color',
				[
					'label'     => esc_html__( 'Title Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-author-info .power-author-bio' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_bio_margin',
				[
					'label'      => esc_html__( 'Title Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info .power-author-bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_bio_padding',
				[
					'label'      => esc_html__( 'Title Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info .power-author-bio' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_author_info_bio_text_shadow',
					'label'    => esc_html__( 'Title Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info .power-author-bio',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'psb_author_info_avater_section',
				[
					'label' => esc_html__( 'Avater', 'power-site-builder' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'psb_author_info_avater_typography',
					'label'    => esc_html__( 'Title Typography', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info img',
				]
			);
			$this->add_control(
				'psb_author_info_avater_text_color',
				[
					'label'     => esc_html__( 'Title Color', 'power-site-builder' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .power-author-info img' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_avater_margin',
				[
					'label'      => esc_html__( 'Title Margin', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'psb_author_info_avater_padding',
				[
					'label'      => esc_html__( 'Title Padding', 'power-site-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .power-author-info img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'psb_author_info_avater_text_shadow',
					'label'    => esc_html__( 'Title Text Shadow', 'power-site-builder' ),
					'selector' => '{{WRAPPER}} .power-author-info img',
				]
			);
			$this->end_controls_section();
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			extract($settings);
			if($psb_author_info_use_custom_author == 'yes' ){
				$name = $psb_author_info_custom_name;
				$bio_html = $psb_author_info_custom_bio != ''  ? '<p class="power-author-bio">'.$psb_author_info_custom_bio.'</p>' : '';
				$url = $psb_author_info_custom_archive_url;
				$avater = $psb_author_info_custom_avater['url'] != '' ?
					Group_Control_Image_Size::get_attachment_image_html( $settings, 'psb_author_info_custom_avater_size', 'psb_author_info_custom_avater' ) : '';
			}else{
				$name = get_the_author();
				$bio_html = get_the_author_meta('description') != '' ? '<p class="power-author-bio">'.get_the_author_meta('description').'</p>' : '';
				$url = get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nickname'));
				$avater = get_avatar(get_the_author_meta( 'ID' ), $psb_author_info_avater_size);

			}
			echo '<div class="power-author-info"> 
				'.Utils::kses($avater).'
				<span class="power-author-prefix">'.esc_html($psb_author_info_name_prefix).'</span><a href="'.esc_url($url).'">'.esc_html($name).'</a>
				'.Utils::kses($bio_html).'
			</div>';
			
		}

		protected function _content_template() { }
	}