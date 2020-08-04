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
			'add_new'            => esc_html__( 'Add New eBay Account', 'ggem' ),
			'add_new_item'       => esc_html__( 'Add New eBay Account', 'ggem' ),
			'edit_item'          => esc_html__( 'Edit eBay Account', 'ggem' ),
			'new_item'           => esc_html__( 'New eBay Account', 'ggem' ),
			'all_items'          => esc_html__( 'eBay Accounts', 'ggem' ),
			'view_item'          => esc_html__( 'View eBay Account', 'ggem' ),
			'search_items'       => esc_html__( 'Search eBay Account', 'ggem' ),
			'not_found'          => esc_html__( 'No eBay Account found', 'ggem' ),
			'not_found_in_trash' => esc_html__( 'No eBay Account found in Trash', 'ggem' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'eBay Account', 'ggem' ),
		];

		$labels = apply_filters( 'ggem_postype_paypal_labels', $labels );

		register_post_type( 'ggem_ebay',
			apply_filters( 'ggem_ebay_post_type_parameters', [
				'labels'              => $labels,
				'supports'            => [ 'title', 'editor' ],
				'public'              => false,
				'hierarchical'        => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				// 'show_in_menu'        => 'ggem',
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'map_meta_cap'        => true,
				'has_archive'         => true,
				'query_var'           => true,
			] )
		);

		$labels2 = [
			'name'               => esc_html__( 'Properties', 'opalestate-pro' ),
			'singular_name'      => esc_html__( 'Property', 'opalestate-pro' ),
			'add_new'            => esc_html__( 'Add New Property', 'opalestate-pro' ),
			'add_new_item'       => esc_html__( 'Add New Property', 'opalestate-pro' ),
			'edit_item'          => esc_html__( 'Edit Property', 'opalestate-pro' ),
			'new_item'           => esc_html__( 'New Property', 'opalestate-pro' ),
			'all_items'          => esc_html__( 'All Properties', 'opalestate-pro' ),
			'view_item'          => esc_html__( 'View Property', 'opalestate-pro' ),
			'search_items'       => esc_html__( 'Search Property', 'opalestate-pro' ),
			'not_found'          => esc_html__( 'No Properties found', 'opalestate-pro' ),
			'not_found_in_trash' => esc_html__( 'No Properties found in Trash', 'opalestate-pro' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Properties', 'opalestate-pro' ),
		];

		register_post_type( 'opalestate_property',
			apply_filters( 'opalestate_property_post_type_parameters', [
				'labels'              => $labels2,
				'supports'            => [ 'title', 'editor', 'thumbnail', 'comments', 'author' ],
				'public'              => true,
				'has_archive'         => true,
				'menu_position'       => 51,
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'query_var'           => true,
				'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
				'show_in_nav_menus'   => true,
			] )
		);
	}
}
