<?php
/**
 * Incomplete interface for an event handler.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */

namespace T5\Core\Events;

interface Event_Handler
{
	/**
	 * @param  string $name
	 * @param  null   $data
	 * @return void
	 */
	public function trigger_event( $name, $data = NULL );
}