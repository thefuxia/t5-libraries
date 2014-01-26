<?php

namespace T5\Core\States;

/**
 * Predictable access to plugin properties.
 *
 * @author  toscho
 * @version 2014.01.24
 * @license MIT
 */
class Plugin_Data implements Freezable
{
	/**
	 * @var bool
	 */
	private $frozen = FALSE;

	/**
	 * @var array
	 */
	private $data = array (
		'file_path'        => '',
		'dir_path'         => '',
		'base_name'        => '',
		'dir_url'          => '',
		'text_domain_path' => '',
		'text_domain'      => '',
		'plugin_uri'       => '',
		'name'             => '',
		'version'          => '',
	);

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
			trigger_error( 'You cannot change a frozen object.', E_USER_ERROR );
			return FALSE;
		}

		$this->data[ $name ] = $value;
		return TRUE;
	}

	/**
	 * @param  string $name
	 * @return string
	 */
	public function get( $name )
	{
		return $this->data[ $name ];
	}

	/**
	 * Path to main plugin file.
	 *
	 * @return string
	 */
	public function get_file_path()
	{
		return $this->get( 'file_path' );
	}

	/**
	 * Path to main plugin directory.
	 *
	 * @return string
	 */
	public function get_dir_path()
	{
		return $this->get( 'dir_path' );
	}

	/**
	 * Plugin basename.
	 *
	 * @return string
	 */
	public function get_base_name()
	{
		return $this->get( 'base_name' );
	}

	/**
	 * URL to plugin directory.
	 *
	 * @return string
	 */
	public function get_dir_url()
	{
		return $this->get( 'dir_url' );
	}

	/**
	 * Path to directory with translation files.
	 *
	 * @return string
	 */
	public function get_text_domain_path()
	{
		return $this->get( 'text_domain_path' );
	}

	/**
	 * Textdomain of the plugin.
	 *
	 * @return string
	 */
	public function get_text_domain()
	{
		return $this->get( 'text_domain' );
	}

	/**
	 * Plugin web address.
	 *
	 * @return string
	 */
	public function get_plugin_uri()
	{
		return $this->get( 'plugin_uri' );
	}

	/**
	 * Plugin name.
	 *
	 * @return string
	 */
	public function get_name()
	{
		return $this->get( 'name' );
	}

	/**
	 * Plugin version.
	 *
	 * @return string
	 */
	public function get_version()
	{
		return $this->get( 'version' );
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
		$this->data['file_path'] = $file;
		$this->data['base_name'] = plugin_basename( $file );
		$this->data['dir_url']   = plugins_url( '/', __FILE__ );

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
			$this->data[ $name ] = $value;
	}
}