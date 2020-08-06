<?php

namespace GGEM\Common\Model\Entity;

use WP_Error;
use WP_Post;

class EBay_Entity {

	/**
	 * The ebay account ID
	 */
	public $ID = 0;

	/**
	 * Declare the default properties in WP_Post as we can't extend it
	 * Anything we've declared above has been removed.
	 */
	public $post_author = 0;
	public $post_date = '0000-00-00 00:00:00';
	public $post_date_gmt = '0000-00-00 00:00:00';
	public $post_content = '';
	public $post_title = '';
	public $post_excerpt = '';
	public $post_status = 'publish';
	public $comment_status = 'open';
	public $ping_status = 'open';
	public $post_password = '';
	public $post_name = '';
	public $to_ping = '';
	public $pinged = '';
	public $post_modified = '0000-00-00 00:00:00';
	public $post_modified_gmt = '0000-00-00 00:00:00';
	public $post_content_filtered = '';
	public $post_parent = 0;
	public $guid = '';
	public $menu_order = 0;
	public $post_mime_type = '';
	public $comment_count = 0;
	public $filter;

	public function __construct( $_id ) {
		$ebay     = WP_Post::get_instance( $_id );
		$this->ID = $_id;

		return $this->setup( $ebay );
	}

	/**
	 * Magic __get function to dispatch a call to retrieve a private ebay
	 */
	public function __get( $key ) {
		if ( method_exists( $this, 'get_' . $key ) ) {
			return call_user_func( [ $this, 'get_' . $key ] );
		} else {
			return new WP_Error( 'ggem-invalid-ebay', sprintf( esc_html__( 'Can\'t get ebay %s', 'ggem' ), $key ) );
		}
	}

	/**
	 * Creates a ebay
	 *
	 * @param array $data Array of attributes for a ebay
	 * @return mixed  false if data isn't passed and class not instantiated for creation, or New Download ID
	 * @since 1.0
	 */
	public function create( $data = [] ) {
		if ( $this->id != 0 ) {
			return false;
		}

		$defaults = [
			'post_type'   => 'ggem_ebay',
			'post_status' => 'draft',
			'post_title'  => esc_html__( 'New Paypal', 'ggem' ),
		];

		$args = wp_parse_args( $data, $defaults );

		/**
		 * Fired before a ebay is created
		 *
		 * @param array $args The post object arguments used for creation.
		 */
		do_action( 'ggem_pre_create', $args );

		$id = wp_insert_post( $args, true );

		$ebay = WP_Post::get_instance( $id );

		/**
		 * Fired after a ebay is created
		 *
		 * @param int   $id   The post ID of the created item.
		 * @param array $args The post object arguments used for creation.
		 */
		do_action( 'ggem_post_create', $id, $args );

		return $this->setup( $ebay );

	}

	/**
	 * Given the ebay data, let's set the variables
	 *
	 * @param WP_Post $ebay The WP_Post object for ebay.
	 * @return bool         If the setup was successful or not
	 */
	private function setup( $ebay ) {
		if ( ! is_object( $ebay ) ) {
			return false;
		}

		if ( ! $ebay instanceof WP_Post ) {
			return false;
		}

		if ( 'ggem_ebay' !== $ebay->post_type ) {
			return false;
		}

		foreach ( $ebay as $key => $value ) {
			$this->$key = $value;
		}

		return true;
	}

	public function get_id() {
		return $this->ID;
	}

	public function get_name() {
		return $this->post_title;
	}

	/**
	 * Get Permerlink
	 *
	 * @return string
	 */
	public function get_link() {
		return get_permalink( $this->ID );
	}

	/**
	 * Posted Date
	 *
	 * Return create post with format by args,it support type: ago, date
	 *
	 * @return string
	 */
	public function get_post_date( $d = '' ) {
		$get_date = $this->post_date;
		if ( '' == $d ) {
			$get_date = mysql2date( get_option( 'date_format' ), $get_date, true );
		} else {
			$get_date = mysql2date( $d, $get_date, true );
		}

		return $get_date;
	}

	/**
	 * Updated Date
	 *
	 * Return create post with format by args,it support type: ago, date
	 *
	 * @return string
	 */
	public function get_updated_date( $d = '' ) {
		$get_date = $this->post_modified;
		if ( '' == $d ) {
			$get_date = mysql2date( get_option( 'date_format' ), $get_date, true );
		} else {
			$get_date = mysql2date( $d, $get_date, true );
		}

		return $get_date;
	}

	/**
	 * Gets meta box value
	 *
	 * Return create post with format by args,it support type: ago, date
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_meta( $key, $single = true ) {
		return get_post_meta( $this->ID, GGEM_METABOX_PREFIX . $key, $single );
	}

	public function is_valid() {
		// TODO:...
		return true;
	}

	public function get_sku() {
		return $this->get_meta( 'sku' );
	}

	public function get_email() {
		return $this->get_meta( 'email' );
	}

	public function get_password() {
		return $this->get_meta( 'password' );
	}

	public function get_user_id() {
		return $this->get_meta( 'user_id' );
	}

	public function get_first_name() {
		return $this->get_meta( 'first_name' );
	}

	public function get_last_name() {
		return $this->get_meta( 'last_name' );
	}

	public function get_status() {
		return $this->get_meta( 'status' );
	}

	public function get_status_label() {
		$statuses = ggem_get_account_statuses();
		$status   = $this->get_status();

		if ( array_key_exists( $status, $statuses ) ) {
			return $statuses[ $status ];
		}

		return __( 'Active', 'ggem' );
	}

	public function get_note() {
		return $this->get_meta( 'note' );
	}

	public function get_date_registerd() {
		return $this->get_meta( 'date_registered' );
	}

	public function get_date_registerd_timestamp() {
		return $this->get_meta( 'date_registered_id' );
	}
}
