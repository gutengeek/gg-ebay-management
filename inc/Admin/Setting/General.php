<?php
namespace GGEM\Admin\Setting;

use GGEM\Core as Core;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */
class General extends Core\Metabox {

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 */
	public function get_tab() {
		return [ 'id' => 'general', 'heading' => esc_html__( 'General' ) ];
	}

	/**
	 * Register User Shortcodes
	 *
	 * Define and register list of user shortcodes such as register form, login form, dashboard shortcode
	 *
	 * @since    1.0.0
	 */
	public function get_settings() {
		$fields = [
			[
				'id'          => 'enable_paypal',
				'name'        => esc_html__( 'Enable PayPal Routing', 'ggem' ),
				'type'        => 'switch',
				'default'     => 'on',
				'description' => sprintf( __( 'Please install and activate <a href="%s" target="_blank">WooCommerce PayPal Checkout Payment Gateway</a> to use this feature.', 'ggem' ),
					esc_url( 'https://wordpress.org/plugins/woocommerce-gateway-paypal-express-checkout/' ) ),
			],
			[
				'id'          => 'enable_stripe',
				'name'        => esc_html__( 'Enable Stripe Routing', 'ggem' ),
				'type'        => 'switch',
				'default'     => 'on',
				'description' => sprintf( __( 'Please install and activate <a href="%s" target="_blank">WooCommerce Stripe Payment Gateway plugin</a> to use this feature.', 'ggem' ),
					esc_url( 'https://wordpress.org/plugins/woocommerce-gateway-stripe/' ) ),
			],
			[
				'id'          => 'limit_money_per_day',
				'name'        => esc_html__( 'Default limit money per day', 'ggem' ),
				'type'        => 'text_number',
				'default'     => '300',
				'description' => esc_html__( 'Default limit money per day', 'ggem' ),
			],
		];

		return apply_filters( 'ggem_settings_general', $fields );
	}
}
