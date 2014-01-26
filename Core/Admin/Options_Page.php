<?php
/**
 * Basic skeleton for an options page.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */

namespace T5\Core\Admin;

use T5\Core\Events\Event_Handler;

class Options_Page
{
	/**
	 * @var Event_Handler
	 */
	private $event_handler;

	/**
	 * @var string
	 */
	private $admin_action;

	/**
	 * Constructor.
	 *
	 * @param Event_Handler $event_handler
	 * @param string        $admin_action
	 */
	public function __construct( Event_Handler $event_handler, $admin_action )
	{
		$this->event_handler = $event_handler;
		$this->admin_action  = $admin_action;
	}

	/**
	 * @return void
	 */
	public function render()
	{
		global $title;
		?>
		<div class="wrap">
			<h1><?=$title?></h1>
			<form method="post" action="<?php print admin_url( 'admin-post.php' ); ?>">
				<input type="hidden" name="action" value="<?=$this->admin_action?>">
				<?php
				$this->event_handler->trigger_event( 'admin.options_page.form.content' );
				submit_button();
				?>
			</form>
		</div>
	<?php
	}
}