<?php

namespace T5\Core\States;

/**
 * Predictable access to plugin properties.
 * Traversable and therefore usable in simple foreach loops.
 *
 * @author  toscho
 * @version 2014.01.24
 * @license MIT
 */
class Plugin_Data implements Freezable, \IteratorAggregate
{
	/**
	 * @var bool
	 */
	private $frozen = FALSE;

	/**
	 * @var string
	 */
	private $file_path;
	private $dir_path;
	private $base_name;
	private $dir_url;
	private $text_domain_path;
	private $text_domain;
	private $plugin_uri;
	private $name;
	private $version;

	/**
	 * Constructor.
	 *
	 * @param string $plugin_file Path to the main plugin file.
	 */
	public function __construct( $plugin_file )
	{
		$this->fill_default_properties( $plugin_file );
	}

	/**
	 * Add or change a property.
	 *
	 * @param  string $name
	 * @param  mixed  $value
	 * @return bool   TRUE on success, FALSE if the object is frozen.
	 */
	public function set( $name, $value )
	{
		if ( $this->frozen )
		{
			# @TODO Rethink: Maybe throw a \RuntimeException?
			trigger_error( 'You cannot change a frozen object.', E_USER_ERROR );
			return FALSE;
		}

		$this->{$name} = $value;
		return TRUE;
	}

	/**
	 * @param  string $name
	 * @return string
	 */
	public function get( $name )
	{
		return $this->{$name};
	}

	/**
	 * Do not allow further changes to the object.
	 *
	 * @return bool
	 */
	public function freeze()
	{
		$this->frozen = TRUE;
	}

	/**
	 * Are changes still possible?
	 *
	 * @return bool
	 */
	public function is_frozen()
	{
		return $this->frozen;
	}

	/**
	 * Set up default properties.
	 *
	 * @param $file
	 * @return void
	 */
	private function fill_default_properties( $file )
	{
		$this->file_path = $file;
		$this->base_name = plugin_basename( $file );
		$this->dir_url   = plugins_url( '/', __FILE__ );

		$headers = get_file_data(
			$file,
			array (
				'text_domain_path' => 'Domain Path',
				'plugin_uri'       => 'Plugin URI',
				'plugin_name'      => 'Name',
				'version'          => 'Version'
			)
		);

		foreach ( $headers as $name => $value )
			$this->{$name} = $value;
	}

	/**
	 * Access to all traversable private properties/plugin file headers.
	 * Maintain access to headers in here.
	 * @return \Traversable
	 */
	public function getIterator()
	{
		return new \ArrayIterator( array(
			'file_path'        => $this->file_path,
			'dir_path'         => $this->dir_path,
			'base_name'        => $this->base_name,
			'dir_url'          => $this->dir_url,
			'text_domain_path' => $this->text_domain_path,
			'text_domain'      => $this->text_domain,
			'plugin_uri'       => $this->plugin_uri,
			'name'             => $this->name,
			'version'          => $this->version,
		) );
	}
}