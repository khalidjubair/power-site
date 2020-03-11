jQuery(document).ready(function ($) {
    "use strict";
    
    function checkAll() { 
        var inputs = document.querySelectorAll('.check3'); 
        for (var i = 0; i < inputs.length; i++) { 
            inputs[i].checked = true; 
        } 
    } 
    window.onload = function() { 
        window.addEventListener('load', checkAll, false); 
    } 
        
    $('#psb-admin-action-form').on('submit', function(e){
        
        var form = $(this);
        var btn = form.find('.psb-admin-action-form-submit');
        var formdata = form.serialize();
        form.addClass('is-loading');
        btn.attr("disabled", true);
        $.post( ajaxurl + '?action=psb_admin_action',formdata, function(formdata ) {
            form.removeClass('is-loading');
            btn.removeAttr("disabled");
        });
        e.preventDefault();
    });
    
});