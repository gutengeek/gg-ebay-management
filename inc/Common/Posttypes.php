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
		static::register_post_status();
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
				'supports'            => [ 'title', 'editor', 'excerpt' ],
				'public'              => true,
				'has_archive'         => true,
				'menu_position'       => 51,
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
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
					'hierarchical'       => true,
					'label'              => __( 'Servers', 'ggem' ),
					'labels'             => [
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
					'publicly_queryable' => false,
					'show_ui'            => true,
					'query_var'          => true,
				]
			)
		);

		register_taxonomy(
			'ggem_payment',
			apply_filters( 'ggem_taxonomy_objects_payment', [ 'ggem_ebay' ] ),
			apply_filters(
				'ggem_taxonomy_args_payment',
				[
					'hierarchical'       => true,
					'label'              => __( 'Payments', 'ggem' ),
					'labels'             => [
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
					'publicly_queryable' => false,
					'show_ui'            => true,
					'query_var'          => true,
				]
			)
		);

		register_taxonomy(
			'ggem_group',
			apply_filters( 'ggem_taxonomy_objects_group', [ 'ggem_ebay' ] ),
			apply_filters(
				'ggem_taxonomy_args_group',
				[
					'hierarchical'       => true,
					'label'              => __( 'Groups', 'ggem' ),
					'labels'             => [
						'name'              => __( 'Groups', 'ggem' ),
						'singular_name'     => __( 'Group', 'ggem' ),
						'menu_name'         => _x( 'Groups', 'Admin menu name', 'ggem' ),
						'search_items'      => __( 'Search groups', 'ggem' ),
						'all_items'         => __( 'All groups', 'ggem' ),
						'parent_item'       => __( 'Parent group', 'ggem' ),
						'parent_item_colon' => __( 'Parent group:', 'ggem' ),
						'edit_item'         => __( 'Edit group', 'ggem' ),
						'update_item'       => __( 'Update group', 'ggem' ),
						'add_new_item'      => __( 'Add new group', 'ggem' ),
						'new_item_name'     => __( 'New group name', 'ggem' ),
						'not_found'         => __( 'No groups found', 'ggem' ),
					],
					'publicly_queryable' => false,
					'show_ui'            => true,
					'query_var'          => true,
				]
			)
		);
	}

	/**
	 * Register our custom post statuses, used for order status.
	 */
	public static function register_post_status() {
		$order_statuses = apply_filters(
			'ggem_register_account_statuses',
			[
				'ggem-active'    => [
					'label'                     => _x( 'Active', 'Account status', 'ggem' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					/* translators: %s: number of orders */
					'label_count'               => _n_noop( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>', 'ggem' ),
				],
				'ggem-suspended' => [
					'label'                     => _x( 'Suspended', 'Account status', 'ggem' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					/* translators: %s: number of orders */
					'label_count'               => _n_noop( 'Suspended <span class="count">(%s)</span>', 'Suspended <span class="count">(%s)</span>', 'ggem' ),
				],
				'ggem-limited'   => [
					'label'                     => _x( 'Limited', 'Account status', 'ggem' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					/* translators: %s: number of orders */
					'label_count'               => _n_noop( 'Limited <span class="count">(%s)</span>', 'Limited <span class="count">(%s)</span>', 'ggem' ),
				],
				'ggem-removed'   => [
					'label'                     => _x( 'Removed', 'Account status', 'ggem' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					/* translators: %s: number of orders */
					'label_count'               => _n_noop( 'Removed <span class="count">(%s)</span>', 'Removed <span class="count">(%s)</span>', 'ggem' ),
				],
			]
		);

		foreach ( $order_statuses as $order_status => $values ) {
			register_post_status( $order_status, $values );
		}
	}
}
