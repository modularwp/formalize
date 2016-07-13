<?php

namespace ModularWP\Formalize;

class DefaultTemplate extends BaseTemplate {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function output( $field, $instance = array() ) {

		// Sets up the output variable.
		$output = '';

		// Generates the field label.
		$output .= $this->generate_label( $instance['args']['label'], $instance['id'] );

		// Generates the field itself.
		$output .= $field->generate_field( $instance );

		// Generates the input description.
		$output .= $this->generate_description( $instance['args']['description'] );

		return $output;
	}
}
