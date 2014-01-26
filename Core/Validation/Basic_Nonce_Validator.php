<?php
namespace T5\Core\Validation;

/**
 * Class Basic_Nonce_Validator
 *
 * A very simple implementation to provide nonces and validation.
 *
 * @version 2014.01.22
 * @author  toscho
 * @license MIT
 */
class Basic_Nonce_Validator implements Nonce_Validator
{
	/**
	 * Current nonce action.
	 *
	 * @var string
	 */
	private $action;

	/**
	 * Current nonce name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Constructor.
	 *
	 * @param string $base
	 * @param bool   $network Should the nonce be used across multiple sites in a network?
	 * @link  http://marketpress.com/2013/how-to-update-custom-fields-in-a-multi-site/
	 */
	public function __construct( $base, $network = TRUE )
	{
		$this->name = $base . '_name';

		if ( ! $network )
			$this->name .= '_' . get_current_blog_id();

		$this->action = $base . '_action';
	}

	/**
	 * Get nonce field name.
	 *
	 * @return string
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Get nonce action.
	 *
	 * @return string
	 */
	public function get_action()
	{
		return $this->action;
	}

	/**
	 * Verify request.
	 *
	 * @return bool
	 */
	public function is_valid()
	{
		return wp_verify_nonce( $_REQUEST[ $this->name ], $this->action );
	}
}