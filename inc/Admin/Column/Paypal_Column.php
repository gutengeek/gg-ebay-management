<?php
namespace GGEM\Admin\Column;

class Paypal_Column {

	/**
	 * Paypal_Column constructor.
	 */
	public function __construct() {
		add_filter( 'manage_ggem_paypal_posts_columns', [ $this, 'set_custom_edit_columns' ] );
		add_action( 'manage_ggem_paypal_posts_custom_column', [ $this, 'custom_column' ], 10, 2 );
	}

	public function set_custom_edit_columns( $columns ) {
		unset( $columns['date'] );
		$columns['api_username']      = __( 'Live API Username', 'ggem' );
		$columns['sandbox_api_username'] = __( 'Sandbox API Username', 'ggem' );
		$columns['deposited_today']   = __( 'Deposited today', 'ggem' );
		$columns['date']              = __( 'Date', 'ggem' );

		return $columns;
	}

	// Add the data to the custom columns for the book post type:
	public function custom_column( $column, $post_id ) {
		$account = ggem_paypal( $post_id );
		switch ( $column ) {
			case 'api_username' :
				echo '<code>' . $account->get_api_username() ? $account->get_api_username() : '---' . '</code>';
				break;

			case 'sandbox_api_username' :
				echo '<code>' . $account->get_sandbox_api_username() ? $account->get_sandbox_api_username() : '---' . '</code>';
				break;

			case 'deposited_today' :
				echo function_exists( 'wc_price' ) ? wc_price( $account->get_deposit() ) : $account->get_deposit();
				break;
		}
	}
}
