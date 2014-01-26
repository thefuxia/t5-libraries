<?php # -*- coding: utf-8 -*-
namespace T5\Core\Autoload;

/**
 * Autoload Rule interface.
 *
 * @author  toscho
 * @version 2013.12.25
 * @license MIT
 */
interface Autoload_Rule
{
	/**
	 * Parse class/trait/interface name and load file.
	 *
	 * @param  string $name
	 * @return boolean
	 */
	public function load( $name );
}