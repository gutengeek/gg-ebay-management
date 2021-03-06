<?php
/**
 * Define
 * Note: only use for internal purpose.
 *
 * @package     GGEM
 * @since       1.0
 */
namespace GGEM\Libraries\Form;

use GGEM\Libraries\Form\Field\File;
use GGEM\Libraries\Form\Field\Map;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the dependencies and enqueueing of the Opaljob JS scripts
 *
 * @package   Opaljob
 * @author    Opal team
 */
class Helper {

	/**
	 * The Opaljob JS handle
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	protected static $handle = 'ggem-form';

	/**
	 * The Opaljob JS variable name
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	protected static $js_variable = 'opalJob_l10';

	/**
	 * Array of Opaljob JS dependencies
	 *
	 * @var   array
	 * @since 1.0.0
	 */
	protected static $dependencies = [
		'jquery' => 'jquery',
	];

	/**
	 * Array of Opaljob fields model data for JS.
	 *
	 * @var   array
	 * @since 1.0.0
	 */
	protected static $fields = [];

	/**
	 * Add a dependency to the array of Opaljob JS dependencies
	 *
	 * @param array|string $dependencies Array (or string) of dependencies to add.
	 * @since 1.0.0
	 */
	public static function add_dependencies( $dependencies ) {
		foreach ( (array) $dependencies as $dependency ) {
			static::$dependencies[ $dependency ] = $dependency;
		}
	}

	/**
	 * Enqueue the form CSS
	 *
	 * @since  1.0.0
	 */
	public static function enqueue_styles() {
		// Iconpicker.
		wp_register_style( 'fonticonpicker', plugin_dir_url( __FILE__ ) . '/assets/3rd/font-iconpicker/css/jquery.fonticonpicker.min.css' );
		wp_register_style( 'fonticonpicker-grey-theme', plugin_dir_url( __FILE__ ) . '/assets/3rd/font-iconpicker/themes/grey-theme/jquery.fonticonpicker.grey.min.css' );

		wp_enqueue_style( 'fonticonpicker' );
		wp_enqueue_style( 'fonticonpicker-grey-theme' );
		wp_enqueue_style( 'font-awesome' );

		// Enqueue CSS.
		wp_enqueue_style( static::$handle, plugin_dir_url( __FILE__ ) . 'assets/css/form.css', [], GGEM_VERSION );
	}

	/**
	 * Enqueue the form JS
	 *
	 * @since  1.0.0
	 */
	public static function enqueue_scripts( $dependencies ) {
		// Only use minified files if SCRIPT_DEBUG is off.
		$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		// if colorpicker.
		if ( isset( $dependencies['wp-color-picker'] ) ) {
			if ( ! is_admin() ) {
				static::colorpicker_frontend();
			}
		}

		// if file/file_list.
		if ( isset( $dependencies['media-editor'] ) ) {
			wp_enqueue_script( 'media-editor' );
			wp_enqueue_media();
			static::load_template_script();
		}

		if ( isset( $dependencies['opal-map'] ) ) {
			wp_enqueue_script( 'ggem-google-maps' );
			wp_enqueue_script( 'ggem-google-maps-js' );
			unset( $dependencies['opal-map'] );
		}

		if ( isset( $dependencies['fonticonpicker'] ) ) {
			wp_enqueue_script( 'fonticonpicker' );
			unset( $dependencies['fonticonpicker'] );
		}

		if ( isset( $dependencies['ggem-uploader-js'] ) ) {
			wp_enqueue_script( 'ggem-uploader-js' );
			unset( $dependencies['ggem-uploader-js'] );
		}

		// Enqueue JS.
		wp_enqueue_script( static::$handle, plugin_dir_url( __FILE__ ) . 'assets/js/form.js', $dependencies, GGEM_VERSION, true );

		static::localize( $debug );

		do_action( 'ggem_footer_enqueue' );
	}

	/**
	 *  Load template script.
	 */
	public static function load_template_script () {
		File::output_js_underscore_templates();
	}

	/**
	 * Localize the php variables for Opaljob JS
	 *
	 * @param mixed $debug Whether or not we are debugging.
	 * @since  1.0.0
	 *
	 */
	protected static function localize( $debug ) {
		static $localized = false;
		if ( $localized ) {
			return;
		}

		$localized = true;
		$l10n      = [
			'script_debug'      => $debug,
			'up_arrow_class'    => 'dashicons dashicons-arrow-up-alt2',
			'down_arrow_class'  => 'dashicons dashicons-arrow-down-alt2',
			'user_can_richedit' => user_can_richedit(),
			'defaults'          => [
				'code_editor'  => false,
				'color_picker' => false,
				'date_picker'  => [
					'changeMonth'     => true,
					'changeYear'      => true,
					'dateFormat'      => _x( 'mm/dd/yy', 'Valid formatDate string for jquery-ui datepicker', 'ggem' ),
					'dayNames'        => explode( ',', esc_html__( 'Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', 'ggem' ) ),
					'dayNamesMin'     => explode( ',', esc_html__( 'Su, Mo, Tu, We, Th, Fr, Sa', 'ggem' ) ),
					'dayNamesShort'   => explode( ',', esc_html__( 'Sun, Mon, Tue, Wed, Thu, Fri, Sat', 'ggem' ) ),
					'monthNames'      => explode( ',', esc_html__( 'January, February, March, April, May, June, July, August, September, October, November, December', 'ggem' ) ),
					'monthNamesShort' => explode( ',', esc_html__( 'Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec', 'ggem' ) ),
					'nextText'        => esc_html__( 'Next', 'ggem' ),
					'prevText'        => esc_html__( 'Prev', 'ggem' ),
					'currentText'     => esc_html__( 'Today', 'ggem' ),
					'closeText'       => esc_html__( 'Done', 'ggem' ),
					'clearText'       => esc_html__( 'Clear', 'ggem' ),
				],
			],
			'strings'           => [
				'upload_file'  => esc_html__( 'Use this file', 'ggem' ),
				'upload_files' => esc_html__( 'Use these files', 'ggem' ),
				'remove_image' => esc_html__( 'Remove Image', 'ggem' ),
				'remove_file'  => esc_html__( 'Remove', 'ggem' ),
				'file'         => esc_html__( 'File:', 'ggem' ),
				'download'     => esc_html__( 'Download', 'ggem' ),
				'check_toggle' => esc_html__( 'Select / Deselect All', 'ggem' ),
			],
		];

		if ( isset( static::$dependencies['code-editor'] ) && function_exists( 'wp_enqueue_code_editor' ) ) {
			$l10n['defaults']['code_editor'] = wp_enqueue_code_editor( [
				'type' => 'text/html',
			] );
		}

		wp_localize_script( static::$handle, static::$js_variable, apply_filters( 'ggem_localized_data', $l10n ) );
	}

	/**
	 * We need to register colorpicker on the front-end
	 *
	 * @since  1.0.0
	 */
	public static function colorpicker_frontend() {
		wp_register_script( 'iris', admin_url( 'js/iris.min.js' ), [ 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ], GGEM_VERSION );
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), [ 'iris' ], GGEM_VERSION );
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', [
			'clear'         => esc_html__( 'Clear', 'ggem' ),
			'defaultString' => esc_html__( 'Default', 'ggem' ),
			'pick'          => esc_html__( 'Select Color', 'ggem' ),
			'current'       => esc_html__( 'Current Color', 'ggem' ),
		] );
	}


	public static function ajax_search_users() {
		$search_query = sanitize_text_field( $_GET['q'] );

		$get_users_args = [
			'number' => 9999,
			'search' => $search_query . '*',
		];

		$get_users_args = apply_filters( 'ggem_search_users_args', $get_users_args );

		$found_users = apply_filters( 'ggem_ajax_found_property_users', get_users( $get_users_args ), $search_query );

		$users = [];
		if ( ! empty( $found_users ) ) {
			foreach ( $found_users as $user ) {
				$object = ggem_new_user_object( $user->ID );
				$users[] = [
					'id'          => $user->ID,
					'name'        => $object->get_name() . ' ('.$user->user_login.')',
					'avatar_url'  => $object->avatar,
					'full_name'   => $object->get_name() . ' ('.$user->user_login.')',
					'description' => 'okokok',
				];
			}
		}

		$output = [
			'total_count'        => count( $users ),
			'items'              => $users,
			'incomplete_results' => false,
		];
		echo json_encode( $output );

		die();
	}
}
