(function ($) {
    'use strict';


    var urlParams = new URLSearchParams(window.location.search);

    if(urlParams.get('admin_tab') == 'widgets'){
        $('#toplevel_page_power-site-builder-dashboard .wp-submenu li:nth-child(1)').addClass('current');
    }

})(jQuery);