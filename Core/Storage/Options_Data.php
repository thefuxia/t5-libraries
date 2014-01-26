<?php

namespace T5\Core\Storage;

/**
 * Get and save data from a single option.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
class Options_Data implements Storable
{
	/**
	 * Option name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Constructor.
	 *
	 * @param string $name Option name.
	 */
	public function __construct( $name )
	{
		$this->name = $name;
	}

	/**
	 * Get stored data.
	 *
	 * @return mixed|void
	 */
	public function get()
	{
		return get_option( $this->name );
	}

	/**
	 * Save data.
	 *
	 * @param  mixed $value
	 * @return bool
	 */
	public function save( $value )
	{
		return update_option( $this->name, $value );
	}
}