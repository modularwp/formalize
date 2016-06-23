<?php

class WP_Formalize_Field_Select extends WP_Formalize_Field {

	/**
	 * Generates the form field
	 *
	 * @param array $instance
	 */
	public function generate_field( $instance = array() ) {

		// Sets up the output variable.
		$output = '';

		// Are there any choices defined?
		if ( is_array( $instance['choices'] ) ) {

			// Opens the field.
			$output .= '<select';

			// Loops through the field attributes.
			foreach( $instance['atts'] as $attribute => $value ) {
				$output .= ' ' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
			}

			// Closes the opening element.
			$output .= '>';

			// Loops through the choices.
			foreach ( $instance['choices'] as $value => $choice ) {

				// Adds options to select list.
				$output .= '<option value="' . esc_attr( $value ) . '" ' . selected( $instance['value'], $value, false ) . '>';
				$output .= esc_html( $choice );
				$output .= '</option>';
			}

			// Closes the field.
			$output .= '</select>';
		}

		return $output;
	}
}
