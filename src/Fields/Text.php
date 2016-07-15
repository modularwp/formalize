<?php

namespace ModularWP\Formalize\Fields;

use ModularWP\Formalize\FieldInterface;
use ModularWP\Formalize\Interfaces\Field;

class Text extends Base {

	/**
	 * Generates the form field
	 *
	 * @param array $instance
	 */
	public function generate_field( $instance = array() ) {

		// Adds the instance value to the attributes array.
		if ( array_key_exists( 'atts', $instance ) && array_key_exists( 'value', $instance['atts'] ) ) {
			$instance['atts']['value'] = $instance['value'];
		}

		// Sets up the output variable.
		$output = '';

		// Opens the field.
		$output .= '<input type="text"';

		// Loops through the field attributes.
		if ( array_key_exists( 'atts', $instance ) ) {
			foreach ( $instance[ 'atts' ] as $attribute => $value ) {
				$output .= ' ' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
			}
		}

		// Closes the field.
		$output .= '>';

		return $output;
	}
}
