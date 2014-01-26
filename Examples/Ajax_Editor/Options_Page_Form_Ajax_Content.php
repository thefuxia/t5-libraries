<?php
namespace T5\Examples\Ajax_Editor;

use T5\Core\Validation\Nonce_Validator;

/**
 * Create the content for the options page form.
 *
 * @author  toscho
 * @version 2014.01.26
 * @license MIT
 */
class Options_Page_Form_Ajax_Content
{
	/**
	 * @var Nonce_Validator
	 */
	private $validator;

	/**
	 * @var string
	 */
	private $ajax_action;

	/**
	 * Constructor.
	 *
	 * @param Nonce_Validator $validator
	 * @param string          $ajax_action
	 */
	public function __construct( Nonce_Validator $validator, $ajax_action )
	{
		$this->validator   = $validator;
		$this->ajax_action = $ajax_action;
	}

	/**
	 * Print form content.
	 *
	 * @param  string $button_id
	 * @param  string $container_id
	 * @return void
	 */
	public function render( $button_id, $container_id )
	{
		wp_nonce_field(
			$this->validator->get_action(),
			$this->validator->get_name()
		);
		?>
		<div id="<?=$container_id?>">
			<?php
			submit_button( 'Get Editor', 'secondary', $button_id, FALSE );
			?>
		</div>
		<?php
		$this->print_script( $button_id, $container_id );
	}

	/**
	 * Print jQuery code for the AJAX request.
	 *
	 * @param  string $button_id
	 * @param  string $container_id
	 * @return void
	 */
	private function print_script( $button_id, $container_id )
	{
		$nonce_name  = $this->validator->get_name();
		$nonce_value = wp_create_nonce( $this->validator->get_action() );
		$data        = "$nonce_name:'$nonce_value',action:'$this->ajax_action'";
		?>
		<script>
		jQuery( document ).ready( function( $ ) {
			var submit = $( '#submit' );
			submit.hide();
			$( '#<?=$button_id?>' ).on( 'click',
				function() {
					$.post( ajaxurl, {<?=$data?>}, function( html ) {
						$('#<?=$container_id?>').html( html );
						submit.show();
					});
					return false;
				}
			);
		});
		</script>
	<?php
	}
}