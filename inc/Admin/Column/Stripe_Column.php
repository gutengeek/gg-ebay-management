<?php
namespace GGEM\Admin\Column;

class Stripe_Column {

	/**
	 * Stripe_Column constructor.
	 */
	public function __construct() {
		add_filter( 'manage_ggem_stripe_posts_columns', [ $this, 'set_custom_edit_columns' ] );
		add_action( 'manage_ggem_stripe_posts_custom_column', [ $this, 'custom_column' ], 10, 2 );
	}

	public function set_custom_edit_columns( $columns ) {
		unset( $columns['date'] );
		$columns['publishable_key']      = __( 'Publishable Key', 'ggem' );
		$columns['test_publishable_key'] = __( 'Test Publishable Key', 'ggem' );
		$columns['deposited_today']      = __( 'Deposited today', 'ggem' );
		$columns['date']                 = __( 'Date', 'ggem' );

		return $columns;
	}

	// Add the data to the custom columns for the book post type:
	public function custom_column( $column, $post_id ) {
		$account = ggem_stripe( $post_id );
		switch ( $column ) {
			case 'publishable_key' :
				echo '<code>' . $account->get_truncated_pk() ? $account->get_truncated_pk() : '---' . '</code>';
				break;

			case 'test_publishable_key' :
				echo '<code>' . $account->get_truncated_test_pk() ? $account->get_truncated_test_pk() : '---' . '</code>';
				break;

			case 'deposited_today' :
				echo function_exists( 'wc_price' ) ?  wc_price( $account->get_deposit() ) : $account->get_deposit();
				break;
		}
	}
}
