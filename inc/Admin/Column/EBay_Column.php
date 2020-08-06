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
		$columns['title']            = __( 'Title', 'ggem' );
		$columns['sku']            = __( 'SKU', 'ggem' );
		$columns['email']          = __( 'Email', 'ggem' );
		$columns['user_id']        = __( 'User ID', 'ggem' );
		$columns['ggem_server']    = __( 'Server', 'ggem' );
		$columns['ggem_payment']   = __( 'Payment', 'ggem' );
		$columns['status']         = __( 'Status', 'ggem' );
		$columns['note']           = __( 'Note', 'ggem' );
		$columns['date_registerd'] = __( 'Date Registered', 'ggem' );

		return $columns;
	}

	// Add the data to the custom columns for the book post type:
	public function custom_column( $column, $post_id ) {
		$account = ggem_ebay( $post_id );
		switch ( $column ) {
			case 'title' :
				echo $account->get_sku();
				break;

			case 'sku' :
				echo $account->get_sku();
				break;

			case 'email' :
				echo $account->get_email();
				break;

			case 'user_id' :
				echo $account->get_user_id();
				break;

			case 'ggem_server' :
				$this->column_server_list( $post_id );
				break;

			case 'ggem_payment' :
				$this->column_payment_list( $post_id );
				break;

			case 'status' :
				echo '<mark class="ggem-account-status ' . $account->get_status() . '"><span>' . $account->get_status_label() . '</span></mark>';
				break;

			case 'note' :
				echo $account->get_note();
				break;

			case 'date_registerd' :
				echo $account->get_date_registerd();
				break;
		}
	}

	/**
	 * Render columm server list.
	 *
	 * @param int    $post_id
	 * @param string $taxonomy
	 */
	protected function column_server_list( $post_id ) {
		$taxonomy = 'ggem_server';
		$terms    = get_the_terms( $post_id, $taxonomy );
		if ( ! $terms ) {
			echo '<span class="na">&ndash;</span>';
		} else {
			foreach ( $terms as $term ) {
				?>
                <div class="ggem-open-popup-wrap">
                    <a href="#" class="ggem-open-popup">
						<?php echo esc_html( $term->name ); ?>
                    </a>

                    <div class="ggem-popup-wrap" style="display: none;">
                        <div class="ggem-popup-bg"></div>
                        <div class="ggem-popup">
                            <div class="ggem-popup-close" tabindex="0" title="<?php esc_attr_e( 'Close', 'ggem' ); ?>">
                                <span class="dashicons dashicons-no-alt"></span>
                            </div>
                            <div class="ggem-popup-form">
                                <div id="ggem-popup-type" class="ggem-popup-body">
                                    <h3 class="ggem-popup-title"><a href="<?php echo get_edit_term_link( $term->term_id, $taxonomy ); ?>"><?php echo esc_html( $term->name ); ?>&nbsp;<i class="dashicons
                                    dashicons-edit-large"></i></a></h3>
                                    <p><b><?php esc_html_e( 'General information', 'ggem' ); ?></b></p>
                                    <table class="table widefat fixed" style="width: 100%; margin-bottom: 15px;">
                                        <tbody>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'IP', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'ip', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'User Name', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'user', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Password', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'password', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Host Name', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'host_name', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Date Registerd', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'date_registered', true ); ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
									<?php if ( $term->description ) : ?>
                                        <p><b><?php esc_html_e( 'More information', 'ggem' ); ?></b></p>
										<?php echo $term->description; ?>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
		}
	}

	/**
	 * Render columm payment list.
	 *
	 * @param int    $post_id
	 * @param string $taxonomy
	 */
	protected function column_payment_list( $post_id ) {
		$taxonomy = 'ggem_payment';
		$terms    = get_the_terms( $post_id, $taxonomy );
		if ( ! $terms ) {
			echo '<span class="na">&ndash;</span>';
		} else {
			foreach ( $terms as $term ) {
				?>
                <div class="ggem-open-popup-wrap">
                    <a href="#" class="ggem-open-popup">
						<?php echo esc_html( $term->name ); ?>
                    </a>

                    <div class="ggem-popup-wrap" style="display: none;">
                        <div class="ggem-popup-bg"></div>
                        <div class="ggem-popup">
                            <div class="ggem-popup-close" tabindex="0" title="<?php esc_attr_e( 'Close', 'ggem' ); ?>">
                                <span class="dashicons dashicons-no-alt"></span>
                            </div>
                            <div class="ggem-popup-form">
                                <div id="ggem-popup-type" class="ggem-popup-body">
                                    <h3 class="ggem-popup-title"><a href="<?php echo get_edit_term_link( $term->term_id, $taxonomy ); ?>"><?php echo esc_html( $term->name ); ?>&nbsp;<i class="dashicons
                                    dashicons-edit-large"></i></a></h3>
                                    <p><b><?php esc_html_e( 'General information', 'ggem' ); ?></b></p>
                                    <table class="table widefat fixed" style="width: 100%; margin-bottom: 15px;">
                                        <tbody>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'User Name', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'user', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Password', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'password', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Date Registerd', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $term->term_id, GGEM_METABOX_PREFIX . 'date_registered', true ); ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
									<?php if ( $term->description ) : ?>
                                        <p><b><?php esc_html_e( 'More information', 'ggem' ); ?></b></p>
										<?php echo $term->description; ?>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
		}
	}
}
