<?php
/**
 * Plugin Name:       GG eBay Management
 * Plugin URI:        https://gutengeek.com
 * Description:       GG eBay Management helps you manage eBay accounts, payment accounts, server accounts,...
 * Version:           1.0.0
 * Author:            GutenGeek
 * Author URI:        https://gutengeek.com/contact
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ggem
 * Domain Path:       /languages
 * WC requires at least: 3.6
 * WC tested up to: 4.2.0
 */

// If this file is called directly, abort.
use GGEM\Core\Init;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Constants
 */
define( 'GGEM', 'ggem' );
define( 'GGEM_VERSION', '1.0.0' );
define( 'GGEM_DIR', plugin_dir_path( __FILE__ ) );
define( 'GGEM_URL', plugin_dir_url( __FILE__ ) );
define( 'GGEM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'GGEM_PLUGIN_TEXT_DOMAIN', 'ggem' );
define( 'GGEM_METABOX_PREFIX', '_' );

require_once( GGEM_DIR . 'vendor/autoload.php' );
require_once( GGEM_DIR . 'inc/Core/functions.php' );
require_once( GGEM_DIR . 'inc/Core/mix-functions.php' );
require_once( GGEM_DIR . 'inc/Core/template-functions.php' );
require_once( GGEM_DIR . 'inc/Core/ajax-functions.php' );

/**
 * Register Activation and Deactivation Hooks
 * This action is documented in inc/core/class-activator.php
 */
register_activation_hook( __FILE__, array( 'GGEM\Core\Activator', 'activate' ) );

/**
 * The code that runs during plugin deactivation.
 * This action is documented inc/core/class-deactivator.php
 */
register_deactivation_hook( __FILE__, array( 'GGEM\Core\Deactivator', 'deactivate' ) );

/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 */
class GGEM {

	/**
	 * The instance of the plugin.
	 *
	 * @var      Init $init Instance of the plugin.
	 */
	private static $init;
	/**
	 * Loads the plugin
	 *
	 * @access    public
	 */
	public static function init() {
		if ( ! class_exists( 'GGEM\Core\Init' ) ) {
			return;
		}

		if ( null === self::$init ) {
			self::$init = new Init();
			self::$init->run();
		}

		return self::$init;
	}
}

/**
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 **/
function ggem_init() {
	return GGEM::init();
}

ggem_init();
