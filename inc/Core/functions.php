<?php

use GGEM\Common\Query\Model\Paypal_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function ggem_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'ggem_clean', $var );
	}

	return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
}

/**
 * Get Options Value by Key
 *
 * @return mixed
 *
 */
function ggem_get_option( $key, $default = '' ) {
	global $ggem_options;

	$value = isset( $ggem_options[ $key ] ) ? $ggem_options[ $key ] : $default;
	$value = apply_filters( 'ggem_option_', $value, $key, $default );

	return apply_filters( 'ggem_option_' . $key, $value, $key, $default );
}

/**
 * Create a new Paypal object.
 *
 * @param $id
 * @return \GGEM\Common\Model\Entity\EBay_Entity
 */
function ggem_ebay( $id ) {
	return new \GGEM\Common\Model\Entity\EBay_Entity( $id );
}

/**
 * Get account statuses.
 *
 * @return array
 */
function ggem_get_account_statuses() {
	return [
		'ggem-active'    => esc_html__( 'Active', 'ggem' ),
		'ggem-suspended' => esc_html__( 'Suspended', 'ggem' ),
		'ggem-limited'   => esc_html__( 'Limited', 'ggem' ),
		'ggem-removed'   => esc_html__( 'Removed', 'ggem' ),
	];
}

/**
 * Dropdown categories.
 *
 * @param array $args Args to control display of dropdown.
 */
function ggem_dropdown_servers( $args = [] ) {
	global $wp_query;

	$args = wp_parse_args(
		$args,
		[
			'pad_counts'         => 1,
			'show_count'         => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'selected'           => isset( $wp_query->query_vars['ggem_server'] ) ? $wp_query->query_vars['ggem_server'] : '',
			'show_option_none'   => __( 'Select a server', 'ggem' ),
			'option_none_value'  => '',
			'value_field'        => 'slug',
			'taxonomy'           => 'ggem_server',
			'name'               => 'ggem_server',
			'class'              => 'dropdown_ggem_server',
		]
	);

	if ( 'order' === $args['orderby'] ) {
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'order'; // phpcs:ignore
	}

	wp_dropdown_categories( $args );
}

/**
 * Dropdown categories.
 *
 * @param array $args Args to control display of dropdown.
 */
function ggem_dropdown_payments( $args = [] ) {
	global $wp_query;

	$args = wp_parse_args(
		$args,
		[
			'pad_counts'         => 1,
			'show_count'         => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'selected'           => isset( $wp_query->query_vars['ggem_payment'] ) ? $wp_query->query_vars['ggem_payment'] : '',
			'show_option_none'   => __( 'Select a payment', 'ggem' ),
			'option_none_value'  => '',
			'value_field'        => 'slug',
			'taxonomy'           => 'ggem_payment',
			'name'               => 'ggem_payment',
			'class'              => 'dropdown_ggem_payment',
		]
	);

	if ( 'order' === $args['orderby'] ) {
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'order'; // phpcs:ignore
	}

	wp_dropdown_categories( $args );
}

/**
 * Dropdown categories.
 *
 * @param array $args Args to control display of dropdown.
 */
function ggem_dropdown_groups( $args = [] ) {
	global $wp_query;

	$args = wp_parse_args(
		$args,
		[
			'pad_counts'         => 1,
			'show_count'         => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'selected'           => isset( $wp_query->query_vars['ggem_group'] ) ? $wp_query->query_vars['ggem_group'] : '',
			'show_option_none'   => __( 'Select a group', 'ggem' ),
			'option_none_value'  => '',
			'value_field'        => 'slug',
			'taxonomy'           => 'ggem_group',
			'name'               => 'ggem_group',
			'class'              => 'dropdown_ggem_group',
		]
	);

	if ( 'order' === $args['orderby'] ) {
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'order'; // phpcs:ignore
	}

	wp_dropdown_categories( $args );
}

if ( ! function_exists( 'ggem_write_log' ) ) {

	/**
	 * Write log.
	 *
	 * @param $log
	 */
	function ggem_write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
