<?php

class WP_Formalize_Field_Textarea extends WP_Formalize_Field {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function generate_field( $instance = array() ) {

		// Sets up the output variable.
		$output = '';

		// Opens the field.
		$output .= '<textarea';

		// Loops through the field attributes.
		foreach( $instance['atts'] as $attribute => $value ) {
			$output .= ' ' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
		}

		// Closes the field.
		$output .= '>';
		$output .= '</textarea>';

		return $output;
	}
}
