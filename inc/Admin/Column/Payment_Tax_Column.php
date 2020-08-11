<?php
namespace GGEM\Admin\Column;

class Payment_Tax_Column {

	/**
	 * EBay_Column constructor.
	 */
	public function __construct() {
		add_filter( 'manage_edit-ggem_payment_columns', [ $this, 'manage_taxonomy_columns' ] );
		add_filter( 'manage_ggem_payment_custom_column', [ $this, 'manage_taxonomy_columns_content' ], 10, 3 );
	}

	public function manage_taxonomy_columns( $columns ) {
		$columns['action'] = __( 'View', 'ggem' );

		unset( $columns['description'] );
		unset( $columns['slug'] );
		unset( $columns['posts'] );

		$columns['slug']  = __( 'Slug', 'ggem' );
		$columns['posts'] = __( 'Count', 'ggem' );

		return $columns;
	}

	public function manage_taxonomy_columns_content( $content, $column_name, $term_id ) {
		if ( 'action' === $column_name ) {
			ob_start();
			$payment = get_term( $term_id );
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
                                    <a href="<?php echo get_edit_term_link( $payment->term_id, 'ggem_payment' ); ?>"><?php echo esc_html( $payment->name ); ?>
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
											<?php esc_html_e( 'Status', 'ggem' ); ?>
                                        </td>
                                        <td>
											<?php
											$statuses = ggem_get_payment_statuses();
											$status   = get_term_meta( $payment->term_id, GGEM_METABOX_PREFIX . 'status', true );
											?>
											<?php echo isset( $statuses[ $status ] ) ? esc_html( $statuses[ $status ] ) : $status; ?>
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

								<?php $related_slug = get_term_meta( $payment->term_id, GGEM_METABOX_PREFIX . 'related', true ); ?>
								<?php if ( $related_slug ) : ?>
									<?php $related = get_term_by( 'slug', $related_slug, 'ggem_payment' ); ?>

                                    <p><b><?php esc_html_e( 'Related', 'ggem' ); ?></b></p>
                                    <table class="table widefat fixed" style="width: 100%; margin-bottom: 15px;">
                                        <thead>
                                        <tr>
                                            <th colspan="2">
                                                <a href="<?php echo get_edit_term_link( $related->term_id, 'ggem_payment' ); ?>"><?php echo esc_html( $related->name ); ?>
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
												<?php echo get_term_meta( $related->term_id, GGEM_METABOX_PREFIX . 'user', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Password', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $related->term_id, GGEM_METABOX_PREFIX . 'password', true ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Status', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php $related_status = get_term_meta( $related->term_id, GGEM_METABOX_PREFIX . 'status', true ); ?>
												<?php echo isset( $statuses[ $related_status ] ) ? esc_html( $statuses[ $related_status ] ) : $related_status; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ggem-table-label">
												<?php esc_html_e( 'Date Registerd', 'ggem' ); ?>
                                            </td>
                                            <td>
												<?php echo get_term_meta( $related->term_id, GGEM_METABOX_PREFIX . 'date_registered', true ); ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
								<?php endif; ?>
								<?php if ( $payment->description ) : ?>
                                    <p><b><?php esc_html_e( 'More information', 'ggem' ); ?></b></p>
									<?php echo esc_html( $payment->description ); ?>
								<?php endif; ?>
                            </div>
                            <footer class="ggem-popup-footer">
                                <a class="button button-primary button-large" href="<?php echo get_edit_term_link( $payment->term_id, 'ggem_payment' ); ?>"><?php esc_html_e( 'Edit', 'ggem' ); ?></a>
                                <a href="#" class="button button-secondary button-large ggem-popup-close" title="<?php esc_attr_e( 'Cancel', 'ggem' ); ?>"> <?php esc_html_e( 'Cancel', 'ggem' ); ?></a>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
			<?php
			$content = ob_get_clean();
		}

		return $content;
	}
}
