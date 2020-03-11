<?php

namespace PowerSiteBuilder\Admin;

class Init{
    function __construct(){
        new Enqueue;
        new Menu\Init;
		new Menu\Ajax;
    }
}