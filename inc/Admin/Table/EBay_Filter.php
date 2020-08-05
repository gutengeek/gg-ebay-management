<?php
namespace GGEM\Admin\Table;

class EBay_Filter {

	/**
	 * EBay_Filter constructor.
	 */
	public function __construct() {
		add_action( 'restrict_manage_posts', [ $this, 'restrict_manage_posts' ] );
	}

	/**
	 * See if we should render search filters or not.
	 */
	public function restrict_manage_posts() {
		global $typenow;

		if ( 'ggem_ebay' === $typenow ) {
			$this->render_filters();
		}
	}

	/**
	 * Render any custom filters and search inputs for the list table.
	 */
	protected function render_filters() {
		$filters = apply_filters(
			'ggem_products_admin_list_table_filters',
			[
				'ggem_server'  => [ $this, 'render_server_filter' ],
				'ggem_payment' => [ $this, 'render_payment_filter' ],
				'ggem_group'   => [ $this, 'render_group_filter' ],
			]
		);

		ob_start();
		foreach ( $filters as $filter_callback ) {
			call_user_func( $filter_callback );
		}
		$output = ob_get_clean();

		echo apply_filters( 'ggem_product_filters', $output ); // WPCS: XSS ok.
	}

	/**
	 * Render the server filter for the list table.
	 */
	protected function render_server_filter() {
		$servers_count = (int) wp_count_terms( 'ggem_server' );

		if ( $servers_count <= apply_filters( 'ggem_server_filter_threshold', 100 ) ) {
			ggem_dropdown_servers(
				[
					'option_select_text' => __( 'Filter by server', 'ggem' ),
					'hide_empty'         => 0,
				]
			);
		} else {
			$current_server_slug = isset( $_GET['ggem_server'] ) ? wc_clean( wp_unslash( $_GET['ggem_server'] ) ) : false; // WPCS: input var ok, CSRF ok.
			$current_server      = $current_server_slug ? get_term_by( 'slug', $current_server_slug, 'ggem_server' ) : false;
			?>
            <select class="ggem-server-search" name="ggem_server" data-placeholder="<?php esc_attr_e( 'Filter by server', 'ggem' ); ?>" data-allow_clear="true">
				<?php if ( $current_server_slug && $current_server ) : ?>
                <option value="<?php echo esc_attr( $current_server_slug ); ?>" selected="selected"><?php echo esc_html( htmlspecialchars( wp_kses_post( $current_server->name ) ) ); ?>
                <option>
					<?php endif; ?>
            </select>
			<?php
		}
	}

	/**
	 * Render the payment filter for the list table.
	 */
	protected function render_payment_filter() {
		$payments_count = (int) wp_count_terms( 'ggem_payment' );

		if ( $payments_count <= apply_filters( 'ggem_payment_filter_threshold', 100 ) ) {
			ggem_dropdown_payments(
				[
					'option_select_text' => __( 'Filter by payment', 'ggem' ),
					'hide_empty'         => 0,
				]
			);
		} else {
			$current_payment_slug = isset( $_GET['ggem_payment'] ) ? wc_clean( wp_unslash( $_GET['ggem_payment'] ) ) : false; // WPCS: input var ok, CSRF ok.
			$current_payment      = $current_payment_slug ? get_term_by( 'slug', $current_payment_slug, 'ggem_payment' ) : false;
			?>
            <select class="ggem-payment-search" name="ggem_payment" data-placeholder="<?php esc_attr_e( 'Filter by payment', 'ggem' ); ?>" data-allow_clear="true">
				<?php if ( $current_payment_slug && $current_payment ) : ?>
                <option value="<?php echo esc_attr( $current_payment_slug ); ?>" selected="selected"><?php echo esc_html( htmlspecialchars( wp_kses_post( $current_payment->name ) ) ); ?>
                <option>
					<?php endif; ?>
            </select>
			<?php
		}
	}

	/**
	 * Render the group filter for the list table.
	 */
	protected function render_group_filter() {
		$groups_count = (int) wp_count_terms( 'ggem_group' );

		if ( $groups_count <= apply_filters( 'ggem_group_filter_threshold', 100 ) ) {
			ggem_dropdown_groups(
				[
					'option_select_text' => __( 'Filter by group', 'ggem' ),
					'hide_empty'         => 0,
				]
			);
		} else {
			$current_group_slug = isset( $_GET['ggem_group'] ) ? wc_clean( wp_unslash( $_GET['ggem_group'] ) ) : false; // WPCS: input var ok, CSRF ok.
			$current_group      = $current_group_slug ? get_term_by( 'slug', $current_group_slug, 'ggem_group' ) : false;
			?>
            <select class="ggem-group-search" name="ggem_group" data-placeholder="<?php esc_attr_e( 'Filter by group', 'ggem' ); ?>" data-allow_clear="true">
				<?php if ( $current_group_slug && $current_group ) : ?>
                <option value="<?php echo esc_attr( $current_group_slug ); ?>" selected="selected"><?php echo esc_html( htmlspecialchars( wp_kses_post( $current_group->name ) ) ); ?>
                <option>
					<?php endif; ?>
            </select>
			<?php
		}
	}
}
