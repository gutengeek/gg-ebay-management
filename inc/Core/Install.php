<?php
namespace GGEM\Core;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
class Install {
	/**
	 * Init.
	 */
	public static function init() {

	}

	/**
	 * Install Opaljob.
	 */
	public static function install() {
		if ( ! is_blog_installed() ) {
			return;
		}

		// Check if we are not already running this routine.
		if ( 'yes' === get_transient( 'ggem_installing' ) ) {
			return;
		}

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient( 'ggem_installing', 'yes', MINUTE_IN_SECONDS * 10 );

		static::update_ggem_version();

		// Add the transient to redirect.
		set_transient( '_ggem_activation_redirect', true, 30 );

		delete_transient( 'ggem_installing' );

		// Remove rewrite rules and then recreate rewrite rules.
		flush_rewrite_rules();

		do_action( 'ggem_installed' );
	}

	/**
	 * Update Opaljob version to current.
	 */
	private static function update_ggem_version() {
		// update_option( 'ggem_version', GGEM_VERSION );
	}
}

