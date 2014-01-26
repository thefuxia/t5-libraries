<?php # -*- coding: utf-8 -*-
namespace T5\Core\Autoload;

/**
 * Autoload Rule for the pattern: "$base_namespace/directories/class_name.php".
 *
 * @author  toscho
 * @version 2013.12.25
 * @license MIT
 */
class Namespace_Base_Autoload_Rule implements Autoload_Rule
{
	/**
	 * Base directory for PHP files.
	 *
	 * @var string
	 */
	private $dir;

	/**
	 * Basic namespace.
	 *
	 * @var string
	 */
	private $namespace;

	/**
	 * Constructor.
	 *
	 * @param string $dir Base directory for PHP files.
	 * @param string $namespace
	 */
	public function __construct( $dir, $namespace )
	{
		$this->dir       = rtrim( $dir, '/\\' );
		$this->namespace = $namespace;
	}

	/**
	 * Load the file.
	 *
	 * @param  string $name
	 * @return bool
	 */
	public function load( $name )
	{
		$parts = explode( '\\', trim( $name, '\\' ) );
		$first = array_shift( $parts );

		if ( $this->namespace !== $first )
			return FALSE;

		$path = $this->dir . '/' . join( '/', $parts ) . '.php';

		if ( ! file_exists( $path ) )
			return FALSE;

		require $path;

		return TRUE;
	}
}