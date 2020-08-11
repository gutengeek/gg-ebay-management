<?php
namespace GGEM\Admin\Metabox;

use GGEM\Core\Metabox;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     WpOpal
 */
class Server_Term_Meta extends Metabox {

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->set_types(
			[
				'ggem_server',
			]
		);
		$this->mode = 'taxonomy';

		$this->metabox_id    = 'ggem-server-metabox-form-data';
		$this->metabox_label = esc_html__( 'Options', 'ggem' );
	}

	/**
	 * Get settings
	 */
	public function get_settings() {
		$prefix = GGEM_METABOX_PREFIX;

		$settings = [
			[
				'name' => esc_html__( 'IP', 'ggem' ),
				'id'   => $prefix . 'ip',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'User Name', 'ggem' ),
				'id'   => $prefix . 'user',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Password', 'ggem' ),
				'id'   => $prefix . 'password',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Host Name', 'ggem' ),
				'id'   => $prefix . 'host_name',
				'type' => 'text',
			],
			[
				'name'    => esc_html__( 'Status', 'ggem' ),
				'id'      => $prefix . 'status',
				'type'    => 'select',
				'options' => ggem_get_server_statuses(),
			],
			[
				'name' => esc_html__( 'Date Registered', 'ggem' ),
				'id'   => $prefix . 'date_registered',
				'type' => 'date',
			],
		];

		return $settings;
	}
}
