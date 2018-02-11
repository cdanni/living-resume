jQuery(document).ready(function( $ ) {
	'use strict';

	if (window.location.href.indexOf("taxonomy=lr_industries") > -1 || window.location.href.indexOf("taxonomy=lr_skills") > -1 || window.location.href.indexOf("taxonomy=lr_tools") > -1) {
		//console.log("on livingresume taxonomy page");
		$('#menu-posts-lr_resume').addClass('wp-has-current-submenu wp-menu-open menu-top').removeClass('wp-not-current-submenu');
		$('#menu-posts-lr_resume > a').addClass('wp-has-current-submenu wp-menu-open menu-top').removeClass('wp-not-current-submenu');
	}
});
