var PSBStickyHandler = function($scope) {
    
}
jQuery(window).on("elementor/frontend/init", function () {
	var widgets = {
		'power_site_builder_sticky_header.default':PSBStickyHandler,
	};
	jQuery.each(widgets, function (widget, callback) {
		elementorFrontend.hooks.addAction('frontend/element_ready/' + widget, callback);
	});
});