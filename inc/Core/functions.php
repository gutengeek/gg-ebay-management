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
 * @return \GGEM\Common\Model\Entity\Paypal_Entity
 */
function ggem_paypal( $id ) {
	return new \GGEM\Common\Model\Entity\Paypal_Entity( $id );
}

/**
 * Create a new Paypal object.
 *
 * @param $id
 * @return \GGEM\Common\Model\Entity\Stripe_Entity
 */
function ggem_stripe( $id ) {
	return new \GGEM\Common\Model\Entity\Stripe_Entity( $id );
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
