<?php
namespace GGEM\Common;

/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/
class Posttypes {

	/**
	 * Register all post types using for this project
	 *
	 * @since    1.0.0
	 */
	public function definition() {

		if ( ! is_blog_installed() || post_type_exists( 'ggem_ebay' ) ) {
			return;
		}

		static::register_ebay_account();
		static::register_taxonomies();
	}

	/**
	 * Register the Candidate Post Type
	 *
	 * @since    1.0.0
	 */
	public static function register_ebay_account() {
		$labels = [
			'name'               => esc_html__( 'eBay Account', 'ggem' ),
			'singular_name'      => esc_html__( 'eBay Account', 'ggem' ),
			'add_new'            => esc_html__( 'Add New Account', 'ggem' ),
			'add_new_item'       => esc_html__( 'Add New Account', 'ggem' ),
			'edit_item'          => esc_html__( 'Edit eBay Account', 'ggem' ),
			'new_item'           => esc_html__( 'New eBay Account', 'ggem' ),
			'all_items'          => esc_html__( 'eBay Accounts', 'ggem' ),
			'view_item'          => esc_html__( 'View eBay Account', 'ggem' ),
			'search_items'       => esc_html__( 'Search eBay Account', 'ggem' ),
			'not_found'          => esc_html__( 'No eBay Account found', 'ggem' ),
			'not_found_in_trash' => esc_html__( 'No eBay Account found in Trash', 'ggem' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'eBay Management', 'ggem' ),
		];

		$labels = apply_filters( 'ggem_postype_paypal_labels', $labels );

		register_post_type( 'ggem_ebay',
			apply_filters( 'ggem_ebay_post_type_parameters', [
				'labels'              => $labels,
				'supports'            => [ 'title', 'editor' ],
				'public'              => true,
				'has_archive'         => true,
				'menu_position'       => 51,
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'query_var'           => true,
				'hierarchical'        => false,
				'show_in_nav_menus'   => true,
			] )
		);
	}

	public static function register_taxonomies() {
		if ( ! is_blog_installed() ) {
			return;
		}

		register_taxonomy(
			'ggem_server',
			apply_filters( 'ggem_taxonomy_objects_server', [ 'ggem_ebay' ] ),
			apply_filters(
				'ggem_taxonomy_args_server',
				[
					'hierarchical' => true,
					'label'        => __( 'Servers', 'ggem' ),
					'labels'       => [
						'name'              => __( 'Servers', 'ggem' ),
						'singular_name'     => __( 'Server', 'ggem' ),
						'menu_name'         => _x( 'Servers', 'Admin menu name', 'ggem' ),
						'search_items'      => __( 'Search servers', 'ggem' ),
						'all_items'         => __( 'All servers', 'ggem' ),
						'parent_item'       => __( 'Parent server', 'ggem' ),
						'parent_item_colon' => __( 'Parent server:', 'ggem' ),
						'edit_item'         => __( 'Edit server', 'ggem' ),
						'update_item'       => __( 'Update server', 'ggem' ),
						'add_new_item'      => __( 'Add new server', 'ggem' ),
						'new_item_name'     => __( 'New server name', 'ggem' ),
						'not_found'         => __( 'No servers found', 'ggem' ),
					],
					'show_ui'      => true,
					'query_var'    => true,
				]
			)
		);

		register_taxonomy(
			'ggem_payment',
			apply_filters( 'ggem_taxonomy_objects_payment', [ 'ggem_ebay' ] ),
			apply_filters(
				'ggem_taxonomy_args_payment',
				[
					'hierarchical' => true,
					'label'        => __( 'Payments', 'ggem' ),
					'labels'       => [
						'name'              => __( 'Payments', 'ggem' ),
						'singular_name'     => __( 'Payment', 'ggem' ),
						'menu_name'         => _x( 'Payments', 'Admin menu name', 'ggem' ),
						'search_items'      => __( 'Search payments', 'ggem' ),
						'all_items'         => __( 'All payments', 'ggem' ),
						'parent_item'       => __( 'Parent payment', 'ggem' ),
						'parent_item_colon' => __( 'Parent payment:', 'ggem' ),
						'edit_item'         => __( 'Edit payment', 'ggem' ),
						'update_item'       => __( 'Update payment', 'ggem' ),
						'add_new_item'      => __( 'Add new payment', 'ggem' ),
						'new_item_name'     => __( 'New payment name', 'ggem' ),
						'not_found'         => __( 'No payments found', 'ggem' ),
					],
					'show_ui'      => true,
					'query_var'    => true,
				]
			)
		);
	}
}
