<?php
namespace GGEM\Admin\Column;

class EBay_Column {

	/**
	 * EBay_Column constructor.
	 */
	public function __construct() {
		add_filter( 'manage_ggem_ebay_posts_columns', [ $this, 'set_custom_edit_columns' ] );
		add_action( 'manage_ggem_ebay_posts_custom_column', [ $this, 'custom_column' ], 10, 2 );
	}

	public function set_custom_edit_columns( $columns ) {
		unset( $columns['date'] );
		$columns['sku']     = __( 'SKU', 'ggem' );
		$columns['email']   = __( 'Email', 'ggem' );
		$columns['user_id'] = __( 'User ID', 'ggem' );
		$columns['status']  = __( 'Status', 'ggem' );
		$columns['note']    = __( 'Note', 'ggem' );
		$columns['date']    = __( 'Date', 'ggem' );

		return $columns;
	}

	// Add the data to the custom columns for the book post type:
	public function custom_column( $column, $post_id ) {
		$account = ggem_ebay( $post_id );
		switch ( $column ) {
			case 'sku' :
				echo $account->get_sku();
				break;

			case 'email' :
				echo $account->get_email();
				break;

			case 'user_id' :
				echo $account->get_user_id();
				break;

			case 'status' :
				echo '<mark class="ggem-account-status ' . $account->get_status() . '"><span>' . $account->get_status_label() . '</span></mark>';
				break;

			case 'note' :
				echo $account->get_note();
				break;
		}
	}
}
