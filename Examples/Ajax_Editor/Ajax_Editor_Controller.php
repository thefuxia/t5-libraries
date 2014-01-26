<?php
namespace T5\Examples\Ajax_Editor;

use T5\Core\Admin\Options_Page;
use T5\Core\Events\Event_Handler;
use T5\Core\Forms\Ajax_Editor;
use T5\Core\Request\Admin_Post_Handler;
use T5\Core\Storage\Options_Data;
use T5\Core\Validation\Basic_Nonce_Validator;

/**
 * Register an options page and the necessary callbacks to store the data.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
class Ajax_Editor_Controller implements Event_Handler
{
	/**
	 * @var string
	 */
	private $editor_id = 't5_ajax_editor';

	/**
	 * @var string
	 */
	private $action = 't5_test_editor';

	/**
	 * @var \T5\Core\Validation\Basic_Nonce_Validator
	 */
	private $validator;


	/**
	 * @var \T5\Core\Storage\Options_Data
	 */
	private $data;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->data      = new Options_Data( $this->editor_id );
		$this->validator = new Basic_Nonce_Validator( 't5_ajax_test' );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			$this->register_ajax_callback();
		else
			$this->register_page_callback();
	}

	/**
	 * @return string
	 */
	public function register_page()
	{
		$page  = new Options_Page( $this, $this->action );
		$title = 'AJAX Editor';
		return add_menu_page(
			$title,
			$title,
			'manage_options',
			'ajax-test',
			[ $page, 'render' ]
		);
	}

	/**
	 * Handle updates from instances creates by this class.
	 *
	 * @param  string $name
	 * @param  null   $data
	 * @return void
	 */
	public function trigger_event( $name, $data = NULL )
	{
		if ( 'admin.options_page.form.content' === $name )
			$this->create_options_page_form_content();

		if ( 'admin.post.update' === $name )
			$this->save_editor_data();
	}

	/**
	 * Create the container and the button to fetch the AJAX editor.
	 *
	 * @return void
	 */
	private function create_options_page_form_content()
	{
		$content = new Options_Page_Form_Ajax_Content(
			$this->validator,
			$this->action
		);
		$content->render( 'get_editor', 't5_editor_container' );
	}

	/**
	 * Save the editor content.
	 *
	 * @return void
	 */
	private function save_editor_data()
	{
		$content = '';

		if ( ! empty ( $_POST[ $this->editor_id ] ) )
			$content = $_POST[ $this->editor_id ];

		$this->data->save( $content );
	}

	/**
	 * Register the AJAX editor callback.
	 *
	 * @return void
	 */
	private function register_ajax_callback()
	{
		$editor = new Ajax_Editor(
			$this->data,
			$this->validator,
			$this->editor_id
		);

		add_action( "wp_ajax_$this->action", [ $editor, 'render' ] );
	}

	/**
	 * Register handler for requests to wp-admin/admin-post.php.
	 *
	 * @return void
	 */
	private function register_page_callback()
	{
		$admin_post = new Admin_Post_Handler( $this, $this->validator );
		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_action( 'admin_post_' . $this->action, [ $admin_post, 'update' ] );
	}
}