<?php

namespace T5\Core\Request;

use T5\Core\Events\Event_Handler;
use T5\Core\Validation\Nonce_Validator;

/**
 * Handle requests to wp-admin/admin-post.php.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
class Admin_Post_Handler
{
	/**
	 * @var Event_Handler
	 */
	private $event_handler;

	/**
	 * @var Nonce_Validator
	 */
	private $validator;

	/**
	 * Constructor.
	 *
	 * @param Event_Handler   $event_handler
	 * @param Nonce_Validator $validator
	 */
	public function __construct(
		Event_Handler   $event_handler,
		Nonce_Validator $validator
	)
	{
		$this->event_handler = $event_handler;
		$this->validator     = $validator;
	}

	/**
	 * Verify request and save the data.
	 *
	 * @return void
	 */
	public function update()
	{
		if ( $this->validator->is_valid() )
			$this->event_handler->trigger_event( 'admin.post.update' );

		wp_safe_redirect( $_POST['_wp_http_referer' ] );

		die;
	}
}