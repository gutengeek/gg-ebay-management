<?php
namespace GGEM\Admin\Metabox;


use GGEM\Core\Metabox;

class EBay_Account_Metabox extends Metabox {
	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->set_types(
			[
				'ggem_ebay',
			]
		);

		$this->metabox_id    = 'ggem-metabox-form-data';
		$this->metabox_label = esc_html__( 'Account Settings', 'ggem' );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadata of the post and stored in post_meta table
	 *
	 * @param string $post_id The id of current post.
	 * @param string $post    The instance of Post having post typo ggem
	 */
	public function save( $post_id, $post ) {
		// $post_id and $post are required.
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}

		// Don't save meta boxes for revisions or autosaves.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check user has permission to edit.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['ggem_meta_nonce'] ) ) {
			$this->save_fields_data( 'post', $post_id );
		}
	}

	/**
	 * Get settings.
	 *
	 * @return array
	 */
	public function get_settings() {
		$prefix = GGEM_METABOX_PREFIX;

		if ( ! class_exists( 'WC_Gateway_PPEC_Plugin' ) ) {
			return [
				[
					'name'        => esc_html__( 'Notice', 'ggem' ),
					'id'          => $prefix . 'notice',
					'type'        => 'title',
					'description' => sprintf( __( 'Please install and activate <a href="%s" target="_blank">WooCommerce PayPal Checkout Payment Gateway</a> to use this feature.', 'ggem' ),
						esc_url( 'https://wordpress.org/plugins/woocommerce-gateway-ebay-express-checkout/' ) ),
				],
			];
		}

		$settings = [
			[
				'name'        => esc_html__( 'Priority', 'ggem' ),
				'id'          => $prefix . 'priority',
				'type'        => 'text_number',
				'description' => esc_html__( 'Priority for this account. The accounts will be taken based on higher priority.', 'ggem' ),
				'default'     => 1,
			],
			// Live
			[
				'name'        => esc_html__( 'Live API Credentials', 'ggem' ),
				'id'          => $prefix . 'live_title',
				'type'        => 'title',
				'description' => esc_html__( 'Live API from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Live API Username', 'ggem' ),
				'id'          => $prefix . 'api_username',
				'type'        => 'text',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Live API Password', 'ggem' ),
				'id'          => $prefix . 'api_password',
				'type'        => 'password',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Live API Signature', 'ggem' ),
				'id'          => $prefix . 'api_signature',
				'type'        => 'text',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Live API Subject', 'ggem' ),
				'id'          => $prefix . 'api_signature',
				'type'        => 'text',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			// Sandbox
			[
				'name'        => esc_html__( 'Sandbox API Credentials', 'ggem' ),
				'id'          => $prefix . 'sandbox_title',
				'type'        => 'title',
				'description' => esc_html__( 'Your account setting is set to sandbox, no real charging takes place. To accept live payments, switch your environment to live and connect your PayPal account.',
					'ggem' ),
			],
			[
				'name'        => esc_html__( 'Sandbox API Username', 'ggem' ),
				'id'          => $prefix . 'sandbox_api_username',
				'type'        => 'text',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Sandbox API Password', 'ggem' ),
				'id'          => $prefix . 'sandbox_api_password',
				'type'        => 'password',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Sandbox API Signature', 'ggem' ),
				'id'          => $prefix . 'sandbox_api_signature',
				'type'        => 'text',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Sandbox API Subject', 'ggem' ),
				'id'          => $prefix . 'sandbox_api_subject',
				'type'        => 'text',
				'description' => esc_html__( 'Get your API credentials from PayPal.', 'ggem' ),
			],
			// App Credentials
			[
				'name'        => esc_html__( 'App Credentials (for Order Tracking, ...)', 'ggem' ),
				'id'          => $prefix . 'app_title',
				'type'        => 'title',
				'description' => esc_html__( 'Go to PayPal Developer and login with your PayPal account > My Apps & Credentials > Live tab > Create App > Enter the name of your application and click Create App button',
					'ggem' ),
			],
			[
				'name'        => esc_html__( 'Live Client ID', 'ggem' ),
				'id'          => $prefix . 'client_id_live',
				'type'        => 'text',
				'description' => esc_html__( 'Get your Client ID from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Live Client Secret', 'ggem' ),
				'id'          => $prefix . 'secret_live',
				'type'        => 'text',
				'description' => esc_html__( 'Get your Client Secret from PayPal.', 'ggem' ),
				'after'       => '<hr>'
			],
			[
				'name'        => esc_html__( 'Sandbox Client ID', 'ggem' ),
				'id'          => $prefix . 'client_id_sandbox',
				'type'        => 'text',
				'description' => esc_html__( 'Get your Client ID from PayPal.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Sandbox Client Secret', 'ggem' ),
				'id'          => $prefix . 'secret_sandbox',
				'type'        => 'text',
				'description' => esc_html__( 'Get your Client Secret from PayPal.', 'ggem' ),
			],
			// Rules
			[
				'name'        => esc_html__( 'Rules', 'ggem' ),
				'id'          => $prefix . 'rules_title',
				'type'        => 'title',
				'description' => esc_html__( 'Set rules for this account.', 'ggem' ),
			],
			[
				'name'        => esc_html__( 'Limit money per day', 'ggem' ),
				'id'          => $prefix . 'limit_money_per_day',
				'type'        => 'text_number',
				'description' => esc_html__( 'Limit money per day. The default limit money is used if empty.', 'ggem' ),
			],
		];

		return apply_filters( 'ggem_ebay_fields_options', $settings );
	}
}
