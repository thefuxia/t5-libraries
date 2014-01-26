<?php
/**
 * Plugin Name: T5 Library
 * Description: Library of WordPress development classes with usage examples.
 * Author:      toscho
 * Version:     2014.01.26
 * License: 	MIT
 */

namespace T5;

foreach ( [ 'Autoload', 'Autoload_Rule', 'Namespace_Base_Autoload_Rule'] as $file )
{
	$fqn = 'T5\Core\Autoload\\' . $file;
	if ( ! class_exists( $fqn ) && ! interface_exists( ! class_exists( $fqn ) ) )
		require_once __DIR__ . "/Core/Autoload/$file.php";
}

$autoloader = new Core\Autoload\Autoload;
$autoloader->add_rule(
	new Core\Autoload\Namespace_Base_Autoload_Rule( __DIR__, __NAMESPACE__ )
);
$autoloader->add_rule(
	new Core\Autoload\Namespace_Base_Autoload_Rule( __DIR__ . '/Examples', __NAMESPACE__ )
);

$examples = glob( __DIR__ . '/Examples/example.*.php' );

foreach ( $examples as $example )
	include $example;

add_action( 'plugins_loaded', function() use ( $autoloader ) {
	do_action( 't5_lib_loaded', $autoloader );
}, 0 );