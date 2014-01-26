<?php
namespace T5\Core\States;

/**
 * Interface Freezable
 *
 * Make an object unchangeable.
 *
 * @version 2014.01.24
 * @author  toscho
 * @license MIT
 */
interface Freezable
{
	/**
	 * Do not allow further changes to the object.
	 *
	 * @return bool
	 */
	public function freeze();

	/**
	 * Are changes still possible?
	 *
	 * @return bool
	 */
	public function is_frozen();
}