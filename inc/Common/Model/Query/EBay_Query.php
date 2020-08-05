<?php
namespace GGEM\Common\Model\Query;

class EBay_Query {
	/**
	 * @param array $args
	 * @return int[]|\WP_Post[]
	 */
	public static function get_paypal_accounts( $args = [] ) {
		$args = wp_parse_args( $args, [
			'numberposts' => -1,
			'post_status' => 'publish',
			'order'       => 'DESC',
			'orderby'     => 'meta_value_num',
			'meta_key'    => GGEM_METABOX_PREFIX . 'priority',
		] );

		$query_args = array_merge( [ 'post_type' => 'ggem_ebay' ], $args );
		$accounts   = get_posts( $query_args );

		return $accounts;
	}
}
