<?php

class WP_Formulate_Field_Textarea extends WP_Formulate_Field {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function output( $instance = array() ) {
		$instance = $this->get_field_settings( $instance );

		// Sets up the output variable.
		$output = '';

		// Generates the field label.
		$output .= $this->get_label( $instance['args']['label'], $instance['id'] );

		// Opens the field.
		$output .= '<textarea';

		// Loops through the field attributes.
		foreach( $instance['atts'] as $attribute => $value ) {
			$output .= ' ' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
		}

		// Closes the field.
		$output .= '>';
		$output .= '</textarea>';

		// Generates the input description.
		$output .= $this->get_description( $instance['args']['desc'] );

		return $output;
	}
}
