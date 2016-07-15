<?php

namespace ModularWP\Formalize\Fields;

use ModularWP\Formalize\FieldInterface;
use ModularWP\Formalize\Interfaces\Field;

class Radio extends Base {

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

			// Loops through the choices.
			foreach ( $instance['choices'] as $value => $choice ) {

				if ( is_array( $choice ) ) {

				} else {
					$label = '<label for="' . $value . '">' . wp_kses_post( $choice ) . '</label>';
				}

				// Opens the field.
				$radio = '<input type="radio" id="' . esc_attr( $value ) . '" name="' . $instance['id'] . '">';

				// Should the label be displayed first?
				if ( !empty( $instance['args']['label_first'] ) ) {
					$output .= '<p>' . $label . ' ' . $radio . '</p>';
				} else {
					$output .= '<p>' . $radio . ' ' . $label . '</p>';
				}
			}
		}

		return $output;
	}
}
