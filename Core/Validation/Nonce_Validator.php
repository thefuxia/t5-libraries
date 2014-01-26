<?php
namespace T5\Core\Validation;

/**
 * Interface Nonce_Validator
 *
 * Provide nonces, and handle their validation.
 *
 * @version 2014.01.22
 * @author toscho
 * @license MIT
 */
interface Nonce_Validator
{
	/**
	 * Get nonce field name.
	 *
	 * @return string
	 */
	public function get_name();

	/**
	 * Get nonce action.
	 *
	 * @return string
	 */
	public function get_action();

	/**
	 * Verify request.
	 *
	 * @return bool
	 */
	public function is_valid();
}