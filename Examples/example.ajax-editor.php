<?php
/**
 * Load the WP_Editor per AJAX request.
 *
 * This examples shows how to use the core classes to build your own plugin.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */

namespace T5\Examples\Ajax_Editor;

is_admin() && add_action( 't5_lib_loaded', function() {
	new Ajax_Editor_Controller();
});