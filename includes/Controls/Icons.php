<?php
namespace PowerSiteBuilder\Controls;

defined( 'ABSPATH' ) || exit;

class Icons{
	public function __construct() {
		add_filter('elementor/icons_manager/additional_tabs', function($tabs){
			$tabs['psbicons'] = [
				'name' => 'psbicons',
				'label' => __( 'Power Icons', 'power-site-builder' ),
				'url' => POWER_SITE_BUILDER_DIR_URL . 'assets/css/psbicons.min.css',
				'enqueue' => [POWER_SITE_BUILDER_DIR_URL . 'assets/css/psbicons.min.css'],
				'prefix' => 'psb-',
				'displayPrefix' => 'psb',
				'labelIcon' => 'psb-ios-add',
				'ver' => POWER_SITE_BUILDER_VERSION,
				'fetchJson' => POWER_SITE_BUILDER_DIR_URL . 'assets/js/psbicons.js?v=' . POWER_SITE_BUILDER_VERSION,
				'native' => false,
			];
			return $tabs;
		}, 10);
    }
}