<?php

namespace PowerSiteBuilder\Controls;

class Init{
    function __construct(){

        new Icons;
        add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );
        
    }

    public function register_controls($controls_manager){
        // control manager
        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        $controls_manager->add_group_control('powerpost', new Post);
    }


}