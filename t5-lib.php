<?php
/**
 * Plugin Name: T5 Library
 * Description: Library of WordPress development classes with usage examples.
 * Author:      toscho
 * Version:     2014.01.26
 * License: 	MIT
 */

namespace T5;

use T5\Core\Autoload\Autoload;
use T5\Core\Autoload\Namespace_Base_Autoload_Rule;

foreach ( [ 'Autoload', 'Autoload_Rule', 'Namespace_Base_Autoload_Rule'] as $file )
{
	$fqn = 'T5\Core\Autoload\\' . $file;
	if ( ! class_exists( $fqn ) && ! interface_exists( ! $fqn ) )
		require_once __DIR__ . "/Core/Autoload/$file.php";
}

$autoloader = new Autoload;
$autoloader->add_rule(
	new Namespace_Base_Autoload_Rule( __DIR__, __NAMESPACE__ )
);

// For plugins
add_action( 'plugins_loaded', function() use ( $autoloader ) {
	do_action( 't5_lib_loaded', $autoloader );
}, 0 );

// For themes
add_action( 'wp_loaded', function() use ( $autoloader ) {
	do_action( 't5_lib_and_wp_loaded', $autoloader );
}, 0 );