<?php # -*- coding: utf-8 -*-
namespace T5\Core\Autoload;

/**
 * Autoloader.
 *
 * @author  toscho
 * @version 2013.12.25
 * @license MIT
 */
class Autoload
{
	/**
	 * List of load rules, implementing \T5\Core\Autoload\Autoload_Rule.
	 *
	 * @var array
	 */
	private $rules = array ();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		spl_autoload_register( [ $this, 'load' ] );
	}

	/**
	 * Add a rule as object instance.
	 *
	 * @param  \T5\Core\Autoload\Autoload_Rule $rule
	 * @return \T5\Core\Autoload\Autoload
	 */
	public function add_rule( Autoload_Rule $rule )
	{
		$this->rules[] = $rule;
		return $this;
	}

	/**
	 * Callback for spl_autoload_register()
	 *
	 * @param  string $name
	 * @return void
	 */
	public function load( $name )
	{
		/** @var \T5\Core\Autoload\Autoload_Rule $rule */
		foreach ( $this->rules as $rule )
		{
			if ( $rule->load( $name ) )
				return;
		}
	}
}