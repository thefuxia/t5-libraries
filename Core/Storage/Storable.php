<?php

namespace T5\Core\Storage;

/**
 * Get and save data.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
interface Storable
{
	/**
	 * Get stored data.
	 *
	 * @return mixed|void
	 */
	public function get();

	/**
	 * Save data.
	 *
	 * @param  mixed $value
	 * @return bool
	 */
	public function save( $value );
}