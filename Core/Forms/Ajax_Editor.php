<?php
namespace T5\Core\Forms;

use T5\Core\Storage\Storable;
use T5\Core\Validation\Nonce_Validator;

/**
 * AJAX callback for the WP Editor.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
class Ajax_Editor
{
	/**
	 * @var Storable
	 */
	private $data;

	/**
	 * @var Nonce_Validator
	 */
	private $validator;

	/**
	 * @var string
	 */
	private $editor_id;

	/**
	 * @var array
	 */
	private $settings = [ 'media_buttons' => FALSE ];

	/**
	 * Constructor.
	 *
	 * @param Storable            $data
	 * @param Nonce_Validator $validator
	 * @param string          $editor_id
	 */
	public function __construct(
		Storable        $data,
		Nonce_Validator $validator,
		$editor_id
	)
	{
		$this->data      = $data;
		$this->validator = $validator;
		$this->editor_id = $editor_id;
	}

	/**
	 * Create the output.
	 *
	 * @return void
	 */
	public function render()
	{
		if ( $this->validator->is_valid() )
			$this->show_editor();

		die;
	}

	/**
	 * Access to editor settings.
	 *
	 * @param  array $settings
	 * @return void
	 */
	public function change_settings( Array $settings )
	{
		$this->settings = $settings;
	}

	/**
	 * Remove all scripts registered on wrong hooks like 'init'.
	 *
	 * @link   https://github.com/johnbillion/query-monitor/issues/48
	 * @return void
	 */
	private function reset_scripts()
	{
		$GLOBALS['wp_scripts'] = new \WP_Scripts();
		$GLOBALS['wp_scripts']->reset();
	}

	/**
	 * @return void
	 */
	private function show_editor()
	{
		$this->reset_scripts();
		wp_editor(
			$this->data->get(),
			$this->editor_id,
			$this->settings
		);
		$this->print_scripts();
	}

	/**
	 * Print editor scripts.
	 *
	 * @return void
	 */
	private function print_scripts()
	{
		\_WP_Editors::enqueue_scripts();
		print_footer_scripts();
		\_WP_Editors::editor_js();
	}
}