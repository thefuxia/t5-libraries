<?php # -*- coding: utf-8 -*-
namespace T5\Core\Resources;

/**
 * Interface to load and unload things.
 *
 * Details are left to the constructor of the implementing classes.
 *
 * @author  toscho
 * @version 2013.12.25
 * @license MIT
 */
interface Loadable
{
	/**
	 * Load something.
	 *
	 * @return bool TRUE on success, FALSE otherwise.
	 */
	public function load();

	/**
	 * Unload.
	 *
	 * @return bool TRUE on success, FALSE otherwise.
	 */
	public function unload();

	/**
	 * Whether or not the resource has been loaded already.
	 *
	 * @return bool
	 */
	public function is_loaded();
}