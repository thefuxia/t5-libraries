<?php # -*- coding: utf-8 -*-

namespace T5\Core\I18n;
use T5\Core\Resources\Loadable;

/**
 * Load translations for themes and plugins.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
class Language_Loader implements Loadable
{
	/**
	 * Path to language directory.
	 *
	 * @var string
	 */
	private $language_dir;

	/**
	 * Name of the text domain.
	 *
	 * @var string
	 */
	private $text_domain;

	/**
	 * Constructor.
	 *
	 * @param string $text_domain  Name of the text domain.
	 * @param string $language_dir Path to language files.
	 */
	public function __construct( $text_domain, $language_dir )
	{
		$this->text_domain  = $text_domain;
		$this->language_dir = rtrim( $language_dir, '/\\' );
	}

	/**
	 * Loads translation file.
	 *
	 * @return bool TRUE when the file was found, FALSE otherwise.
	 */
	public function load()
	{
		return load_textdomain(
			$this->text_domain,
			"$this->language_dir/$this->text_domain-" . get_locale() . '.mo'
		);
	}

	/**
	 * Remove translations from memory.
	 *
	 * @return bool TRUE if the text domain was loaded, FALSE if it was not.
	 */
	public function unload()
	{
		return unload_textdomain( $this->text_domain );
	}


	/**
	 * Whether or not the language has been loaded already.
	 *
	 * @return bool
	 */
	public function is_loaded()
	{
		return is_textdomain_loaded( $this->text_domain );
	}
}