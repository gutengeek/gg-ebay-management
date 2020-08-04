<?php
/**
 * Define
 * Note: only use for internal purpose.
 *
 * @package     GGEM
 * @since       1.0
 */
namespace GGEM\Libraries\Form\Field;

use GGEM\Libraries\Form\Form;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HTML Form
 *
 * A helper class for outputting common HTML elements, such as product drop downs
 *
 * @package     GGEM
 * @subpackage  GGEM\Libraries
 */
class Map {
	/**
	 * @var array
	 */
	public $args;

	/**
	 * @var \GGEM\Libraries\Form\Form
	 */
	public $form;

	/**
	 * @var
	 */
	public $type;

	/**
	 * Init Constructor of this
	 *
	 * @return string
	 *
	 */
	public function __construct( $args, Form $form ) {
		$classes = [
			'ggem-map-field',
			'regular-text',
			'form-control',
		];

		$defaults = [
			'id'          => '',
			'name'        => '',
			'description' => '',
			'class'       => esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ),
		];

		$args = wp_parse_args( $args, $defaults );

		$this->args = $args;
		$this->form = $form;

		$this->render();
	}

	/**
	 * Render.
	 */
	public function render() {
		$this->form->add_dependencies( 'opal-map' );

		$args      = $this->args;
		$value     = $this->form->get_field_value( $args );
		$address   = ( isset( $value['address'] ) ? esc_attr( $value['address'] ) : '' );
		$latitude  = ( isset( $value['latitude'] ) ? esc_attr( $value['latitude'] ) : '' );
		$longitude = ( isset( $value['longitude'] ) ? esc_attr( $value['longitude'] ) : '' );

		if ( $args['name'] ) {
			echo '<label class="ggem-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';
		}

		echo '<div class="ggem-field-wrap ggem-map-field-wrap form-group row opal-row">
			<div class="ggem-map-wrap col-sm-6">
				<div class="opal-map"></div>
			</div>
			<div class="col-sm-6">
					<div  class="form-group">
						<label>' . esc_html__( 'Address', 'ggem' ) . '</label>
						<input type="text" class="large-text regular-text opal-map-search  form-control" id="' . $args['id'] . '" 
						name="' . $args['id'] . '[address]" value="' . $address . '"/>';
		echo '</div>';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="ggem-description">' . esc_html( $args['description'] ) . '</p>';
		}

		echo ' <div class="form-group">';
		echo '<label>' . esc_html__( 'Latitude', 'ggem' ) . '</label>';

		printf( '<input type="text" class="opal-map-latitude form-control"  name="%1$s" value="%2$s" />',
			$args['id'] . '[latitude]',
			$latitude
		);

		echo '</div>';
		echo ' <div class="form-group">';
		echo '<label>' . esc_html__( 'Longitude', 'ggem' ) . '</label>';

		printf( '<input type="text" class="opal-map-longitude form-control"  name="%1$s" value="%2$s" />',
			$args['id'] . '[longitude]',
			$longitude
		);

		echo '</div>';
		echo '<p class="opal-map-desc ggem-description">' . esc_html__( 'You need to register <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google API Key</a>, then put the key in plugin setting.',
				'ggem' ) . '</p>';

		echo '</div>';
		echo '</div>';
	}

	/**
	 * Gets Google Map API URI.
	 *
	 * @return mixed|string|void
	 */
	public static function get_map_api_uri() {
		$key = ggem_get_option( 'google_map_api_keys' ) ? ggem_get_option( 'google_map_api_keys' ) : 'AIzaSyCfMVNIa7khIqYHCw6VBn8ShUWWm4tjbG8';
		$api = 'https://maps.googleapis.com/maps/api/js?key=' . $key . '&libraries=geometry,places,drawing&ver=5.2.2';
		$api = apply_filters( 'ggem_google_map_api_uri', $api );
		return $api;
	}
}
