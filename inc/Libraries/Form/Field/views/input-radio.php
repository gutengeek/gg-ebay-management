<?php
$defaults = [
	'options'          => [],
	'name'             => null,
	'class'            => 'form-control',
	'id'               => '',
	'autocomplete'     => 'off',
	'chosen'           => false,
	'multiple'         => false,
	'select_atts'      => false,
	'show_option_all'  => esc_html__( 'All', 'ggem' ),
	'show_option_none' => esc_html__( 'None', 'ggem' ),
	'data'             => [],
	'default'          => '',
];

$args   = wp_parse_args( $args, $defaults );
$valued = $this->get_field_value( $args );
if ( null == $valued ) {
	$value = $args['default'] ? esc_attr( $args['default'] ) : '';
} else {
	$value = $valued ? $valued : '';
}

$data_elements = '';
foreach ( $args['data'] as $key => $value ) {
	$data_elements .= ' data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
}

if ( $args['chosen'] ) {
	$args['class'] .= ' ggem-select-chosen';
}

$inline_class = isset( $args['type'] ) && ( 'radio_inline' === $args['type'] ) ? 'inline-list' : '';
$output       = '<div class="ggem-field-wrap ggem-radio-field-wrap form-group" id="' . sanitize_key( $this->form_id . $args['id'] ) . '-wrap" >';
$output       .= '<label class="ggem-label" for="' . esc_attr( sanitize_key( str_replace( '-', '_', $this->form_id . $args['id'] ) ) ) . '">' . esc_html( $args['name'] ) . '</label>';

$output .= '<ul class="ggem-radio ' . $inline_class . '">';
if ( ! empty( $args['options'] ) ) {
	foreach ( $args['options'] as $key => $option ) {
		$_id     = esc_attr( sanitize_key( str_replace( '-', '_', $this->form_id . $args['id'] . $key ) ) );
		$checked = checked( $value, $key, false );
		$output  .= '<li><input name="' . esc_attr( $args['id'] ) . '" id="' . esc_attr( $_id ) . '" type="radio" value="' . esc_attr( $key ) . '"' . $checked . '/><label for="' . esc_attr( $_id ) .
		            '">'
		            . esc_html( $option ) . '</label></li>';
	}
}
$output .= '</ul>';
$output .= '</div>';

echo $output;
