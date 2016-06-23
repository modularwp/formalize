<?php

class WP_Formalize_Field_Color extends WP_Formalize_Field {

	/**
	 * Generates the form field
	 *
	 * @param array $instance
	 */
	public function generate_field( $instance = array() ) {

		// Adds the instance value to the attributes array.
		$instance['atts']['value'] = $instance['value'];

		// Adds "formalize-color" class to input (required for color picker Javascript to work)
		$instance['atts']['class'] = !empty( $instance['atts']['class'] ) ? $instance['atts']['class'] . ' formalize-color' : 'formalize-color';

		// Sets up the output variable.
		$output = '';

		// Opens the field.
		$output .= '<input type="text"';

		// Loops through the field attributes.
		foreach( $instance['atts'] as $attribute => $value ) {
			$output .= ' ' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
		}

		// Closes the field.
		$output .= '>';

		return $output;
	}

	/**
	 * Enqueues files
	 */
	public static function enqueue() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'formalize-color-js', plugin_dir_url( __FILE__ ) . '/field-color.js', array( 'wp-color-picker' ) );
	}

}
