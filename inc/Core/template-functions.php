<?php
/**
 * @param       $template
 * @param array $args
 * @return string
 */
function ggem_get_template( $template, $args = [] ) {
	return GGEM\Core\View::render_template( $template, $args );
}

/**
 * Render template.
 */
function ggem_render_template( $template, $args = [] ) {
	echo ggem_get_template( $template, $args );
}
