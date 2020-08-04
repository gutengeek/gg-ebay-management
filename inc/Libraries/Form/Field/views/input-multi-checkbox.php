<?php
$classes = [
	'ggem-multicheckbox-field',
	'regular-text',
	'form-control',
];

$defaults = [
	'id'                => '',
	'name'              => '',
	'show_label'        => true,
	'options'           => [],
	'description'       => null,
	'class'             => esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ),
	'select_all_button' => false,
	'inline'            => false,
];

$args  = wp_parse_args( $args, $defaults );
$value = $this->get_field_value( $args );

$output = '<div class="ggem-field-wrap ggem-multicheckbox-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap" >';
if ( $args['show_label'] ) {
	$output .= '<label class="ggem-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';
}

$display_class = isset( $args['inline'] ) && $args['inline'] ? 'checkbox-inline' : 'checkbox-block';
$output        .= '<div class="ggem-field-main">';

if ( isset( $args['select_all_button'] ) && $args['select_all_button'] ) {
	$output .= '<div class="ggem-multicheck-action"><span class="button-secondary ggem-multicheck-toggle">' . esc_html__( 'Select / Deselect All', 'ggem' ) . '</span></div>';
}

$output .= '<div class="checkbox-list ' . $display_class . '">';

foreach ( $args['options'] as $key => $option_name ) {
	$checked = ( null !== $value && $value ) ? checked( true, in_array( $key, $value ), false ) : '';

	$_id = sanitize_key( $this->form_id . $args['id'] ) . '_' . $key;

	$output .= '<span class="checkbox-item">';
	$output .= '<input type="checkbox" name="' . esc_attr( $args['id'] ) . '[]" id="' . esc_attr( $_id ) . '" value="' . $key . '" class="form-control-checkbox" ' . $checked . ' ' . ' />';
	$output .= '<label class="ggem-option-label" for="' . $_id . '">' . esc_html( $option_name ) . '</label>';
	$output .= '</span>';
}

$output .= '</div>';

if ( ! empty( $args['description'] ) ) {
	$output .= '<p class="ggem-description">' . $args['description'] . '</p>';
}
$output .= '</div>';
$output .= '</div>';

echo $output;
