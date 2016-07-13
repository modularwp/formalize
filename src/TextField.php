<?php

namespace ModularWP\Formalize;

class TextField extends BaseField {

	/**
	 * Generates the form field
	 *
	 * @param array $instance
	 */
	public function generate_field( $instance = array() ) {

		// Adds the instance value to the attributes array.
		$instance['atts']['value'] = $instance['value'];

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
