<?php

namespace ModularWP\Formalize\Fields;

use ModularWP\Formalize\FieldInterface;
use ModularWP\Formalize\Interfaces\Field;

class Textarea extends Base {

	/**
	 * Generates the form field
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

		// Closes the opening element.
		$output .= '>';

		// Adds content to text area if available.
		$output .= !empty( $instance['value'] ) ? esc_textarea( $instance['value'] ) : '';

		// Closes the field.
		$output .= '</textarea>';

		return $output;
	}
}
