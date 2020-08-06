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
		$columns['action']         = __( 'View', 'ggem' );
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
			case 'action' :
				$this->column_account_detail( $account );
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
                            <div class="ggem-popup-form">
                                <header class="ggem-popup-header">
                                    <h3 class="ggem-popup-title">
                                        <a href="<?php echo get_edit_term_link( $term->term_id, $taxonomy ); ?>"><?php echo esc_html( $term->name ); ?>
                                            &nbsp<i class="dashicons dashicons-edit-large"></i>
                                        </a>
                                    </h3>
                                    <div class="ggem-popup-top-close ggem-popup-close" tabindex="0" title="<?php esc_attr_e( 'Close', 'ggem' ); ?>">
                                        <span class="dashicons dashicons-no-alt"></span>
                                    </div>
                                </header>
                                <div class="ggem-popup-body">
                                    <p><b><?php esc_html_e( 'General', 'ggem' ); ?></b></p>
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
										<?php echo esc_html( $term->description ); ?>
									<?php endif; ?>
                                </div>
                                <footer class="ggem-popup-footer">
                                    <a class="button button-primary button-large" href="<?php echo get_edit_term_link( $term->term_id, $taxonomy ); ?>"><?php esc_html_e( 'Edit', 'ggem' ); ?></a>
                                    <a href="#" class="button button-secondary button-large ggem-popup-close" title="<?php esc_attr_e( 'Cancel', 'ggem' ); ?>"> <?php esc_html_e( 'Cancel',
											'ggem' ); ?></a>
                                </footer>
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
                            <div class="ggem-popup-form">
                                <header class="ggem-popup-header">
                                    <h3 class="ggem-popup-title">
                                        <a href="<?php echo get_edit_term_link( $term->term_id, $taxonomy ); ?>"><?php echo esc_html( $term->name ); ?>
                                            &nbsp<i class="dashicons dashicons-edit-large"></i>
                                        </a>
                                    </h3>
                                    <div class="ggem-popup-top-close ggem-popup-close" tabindex="0" title="<?php esc_attr_e( 'Close', 'ggem' ); ?>">
                                        <span class="dashicons dashicons-no-alt"></span>
                                    </div>
                                </header>
                                <div class="ggem-popup-body">
                                    <p><b><?php esc_html_e( 'General', 'ggem' ); ?></b></p>
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
										<?php echo esc_html( $term->description ); ?>
									<?php endif; ?>
                                </div>
                                <footer class="ggem-popup-footer">
                                    <a class="button button-primary button-large" href="<?php echo get_edit_term_link( $term->term_id, $taxonomy ); ?>"><?php esc_html_e( 'Edit', 'ggem' ); ?></a>
                                    <a href="#" class="button button-secondary button-large ggem-popup-close" title="<?php esc_attr_e( 'Cancel', 'ggem' ); ?>"> <?php esc_html_e( 'Cancel',
											'ggem' ); ?></a>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
		}
	}

	/**
	 * @param \GGEM\Common\Model\Entity\EBay_Entity $account
	 */
	public function column_account_detail( $account ) {
		?>
        <div class="ggem-open-popup-wrap" style="display: inline-block">
            <a href="#" class="ggem-open-popup">
                <button class="ggem-open-popup-button"><i class="dashicons dashicons-visibility"></i></button>
            </a>
            <div class="ggem-popup-wrap" style="display: none;">
                <div class="ggem-popup-bg"></div>
                <div class="ggem-popup wide">
                    <div class="ggem-popup-form">
                        <header class="ggem-popup-header">
                            <h3 class="ggem-popup-title">
                                <a href="<?php echo get_edit_post_link( $account->get_id() ); ?>"><?php echo esc_html( $account->get_name() ); ?>
                                    &nbsp<i class="dashicons dashicons-edit-large"></i>
                                </a>
                            </h3>
	                        <div class="ggem-popup-top-status">
		                        <mark class="ggem-account-status <?php echo esc_attr( $account->get_status() ); ?>">
			                        <span><?php echo esc_html( $account->get_status_label() ); ?></span>
		                        </mark>
	                        </div>
                            <div class="ggem-popup-top-close ggem-popup-close" tabindex="0" title="<?php esc_attr_e( 'Close', 'ggem' ); ?>">
                                <span class="dashicons dashicons-no-alt"></span>
                            </div>
                        </header>
                        <div class="ggem-popup-body">
                            <p><b><?php esc_html_e( 'General', 'ggem' ); ?></b></p>
                            <table class="table widefat fixed" style="width: 100%; margin-bottom: 15px;">
                                <tbody>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'SKU', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_sku() ) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'Email', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_email() ) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'User ID', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_user_id() ) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'Password', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_password() ) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'First Name', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_first_name() ) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'Last Name', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_last_name() ) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ggem-table-label">
										<?php esc_html_e( 'Date Registered', 'ggem' ); ?>
                                    </td>
                                    <td>
										<?php echo esc_html( $account->get_date_registerd() ) ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p><b><?php esc_html_e( 'Server', 'ggem' ); ?></b></p>
							<?php $servers = get_the_terms( $account->get_id(), 'ggem_server' ); ?>
							<?php if ( ! $servers ) : ?>
                                <span class="na">&ndash;<?php esc_html_e( 'No server informaiton exist!' ); ?></span>
							<?php else : ?>
								<?php foreach ( $servers as $server ) : ?>
                                    <table class="table widefat fixed" style="width: 100%; margin-bottom: 15px;">
                                        <thead>
                                        <tr>
                                            <th colspan="2">
                                                <a href="<?php echo get_edit_term_link( $server->term_id, 'ggem_server' ); ?>"><?php echo esc_html( $server->name ); ?>
                                                    &nbsp<i class="dashicons dashicons-edit-large"></i>
                                                </a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'IP', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $server->term_id, GGEM_METABOX_PREFIX . 'ip', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'User Name', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $server->term_id, GGEM_METABOX_PREFIX . 'user', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Password', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $server->term_id, GGEM_METABOX_PREFIX . 'password', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Host Name', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $server->term_id, GGEM_METABOX_PREFIX . 'host_name', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Date Registerd', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $server->term_id, GGEM_METABOX_PREFIX . 'date_registered', true ); ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
								<?php endforeach; ?>
							<?php endif; ?>

                            <p><b><?php esc_html_e( 'Payment', 'ggem' ); ?></b></p>
							<?php $payments = get_the_terms( $account->get_id(), 'ggem_payment' ); ?>
							<?php if ( ! $payments ) : ?>
                                <span class="na">&ndash;<?php esc_html_e( 'No payment informaiton exist!' ); ?></span>
							<?php else : ?>
								<?php foreach ( $payments as $payment ) : ?>
                                    <table class="table widefat fixed" style="width: 100%; margin-bottom: 15px;">
                                        <thead>
                                        <tr>
                                            <th colspan="2">
                                                <a href="<?php echo get_edit_term_link( $payment->term_id, 'ggem_payment' ); ?>"><?php echo esc_html( $payment->name ); ?>
                                                    &nbsp<i class="dashicons dashicons-edit-large"></i>
                                                </a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'User Name', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $payment->term_id, GGEM_METABOX_PREFIX . 'user', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Password', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $payment->term_id, GGEM_METABOX_PREFIX . 'password', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Date Registerd', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $payment->term_id, GGEM_METABOX_PREFIX . 'date_registered', true ); ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if ( $account->post_content ) : ?>
                                <p><b><?php esc_html_e( 'More information', 'ggem' ); ?></b></p>
								<?php echo esc_html( $account->post_content ); ?>
							<?php endif; ?>
                        </div>
                        <footer class="ggem-popup-footer">
                            <a class="button button-primary button-large" href="<?php echo get_edit_post_link( $account->get_id() ); ?>"><?php esc_html_e( 'Edit', 'ggem' ); ?></a>
                            <a href="#" class="button button-secondary button-large ggem-popup-close" title="<?php esc_attr_e( 'Cancel', 'ggem' ); ?>"> <?php esc_html_e( 'Cancel', 'ggem' ); ?></a>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
}
