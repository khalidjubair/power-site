<?php
namespace PowerSiteBuilder\Cptui;

if ( !defined( 'ABSPATH' ) )
	die( 'Direct access forbidden.' );

class Init {

	private static $initialized	 = false;
    public function __construct() {
    
		$cpt = new Cpt( 'power_site_builder' );		
		$cpt_tax = new  CptTax('power_site_builder');
 
		$cpt->init( 
			'psb_portfolio', 
			'Portfolio', 
			'Portfolios', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
					'excerpt', 
					'thumbnail' 
				],
				'rewrite'	 => [
					'slug' => 'psb_portfolio' 
				]
			]
		);
		$cpt_tax->init(
			'psb_portfolio_cat', 
			'Portfolio Category', 
			'Portfolio Categories', 
			'psb_portfolio',
			'manage_categories'
		);

		$cpt->init( 
			'psb_service', 
			'Service', 
			'Services', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
					'thumbnail' 
				],
				'rewrite'	 => [
					'slug' => 'psb_service' 
				]
			]
		);
		$cpt_tax->init(
			'psb_service_cat', 
			'Service Category', 
			'Service Categories', 
			'psb_service',
			'manage_categories'
		);

		$cpt->init( 
			'psb_mega_menu', 
			'Mega Menu', 
			'Mega Menu', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
				],
				'rewrite'	 => [
					'slug' => 'psb_mega_menu' 
				]
			]
		);
		$cpt->init( 
			'psb_template', 
			'My Templates', 
			'My Templates', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
				],
				'rewrite'	 => [
					'slug' => 'psb_template' 
				]
			]
		);
		$cpt_tax->init(
			'psb_template_cat', 
			'Position', 
			'Position', 
			'psb_template',
			''
		);
		$cpt->init( 
			'psb_header_footer', 
			'Header Footer', 
			'Header Footer', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
				],
				'rewrite'	 => [
					'slug' => 'psb_header_footer' 
				]
			]
		);
		$cpt_tax->init(
			'psb_header_footer_cat', 
			'Position', 
			'Position', 
			'psb_header_footer',
			''
		);

		$cpt->init( 
			'psb_nested', 
			'Nested Template', 
			'Nested Templates', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
				],
				'rewrite'	 => [
					'slug' => 'psb_nested' 
				]
			]
		);
		$cpt->init( 
			'psb_block', 
			'Block', 
			'Blocks', 
			[ 'menu_icon'	 => 
				'dashicons-exerpt-view',
				'supports'	 => [
					'title', 
					'editor', 
				],
				'rewrite'	 => [
					'slug' => 'psb_block' 
				]
			]
		);
		// $cpt->init( 
		// 	'psb_form', 
		// 	'Forms', 
		// 	'Forms', 
		// 	[ 'menu_icon'	 => 
		// 		'dashicons-exerpt-view',
		// 		'supports'	 => [
		// 			'title', 
		// 			'editor', 
		// 		],
		// 		'rewrite'	 => [
		// 			'slug' => 'psb_form' 
		// 		]
		// 	]
		// );
		
		if ( self::$initialized ) {
			return;
		} else {
			self::$initialized = true;
		}

		add_action('init', [ __CLASS__, 'insert_terms' ]);
		add_action('single_template', [ __CLASS__, 'set_page_template' ], 10, 3 );
		add_action('init', [ __CLASS__, 'add_elementor_support' ], 10, 3 );
		 
	}
	
		
	public static function insert_terms(){
		$h_term = wp_insert_term(
			'Header',
			'psb_header_footer_cat',
			array(
				'description' => 'Shows on Header',
				'slug'        => 'psb_header_term',
				'parent'      => 0,
			)
		);
		$f_term = wp_insert_term(
			'Footer',
			'psb_header_footer_cat',
			array(
				'description' => 'Shows on Footer',
				'slug'        => 'psb_footer_term',
				'parent'      => 0,
			)
		);
	}

	public static function set_page_template( $template ) {
		global $post;
		$template_path = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
		if ('psb_header_footer' === $post->post_type || 
			'psb_nested' === $post->post_type || 
			'psb_template' === $post->post_type || 
			'psb_form' === $post->post_type || 
			'psb_block' === $post->post_type 
		){
			if ( file_exists( $template_path ) ) {
				return $template_path;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}
		return $template;
	}

	public static function add_elementor_support() {
		$elementor_support = get_option( 'elementor_cpt_support' );
		$default_supports = [ 'psb_header_footer', 'psb_nested',  'psb_block', 'psb_template', 'psb_form' ];
		if( ! $elementor_support ) {
			$elementor_support = $default_supports;
		}else{
			foreach($default_supports as $default_support){
				if( ! in_array( $default_support, $elementor_support ) ) {
					$elementor_support[] = $default_support;
				}
			}
		}
		update_option( 'elementor_cpt_support', $elementor_support );
	}
}