<?php

class WP_Formalize_Field_Text extends WP_Formalize_Field {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function generate_field( $instance = array() ) {
		if ( $instance['value'] ) {
			$instance['atts']['value'] = $instance['value'];
		}

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
}
