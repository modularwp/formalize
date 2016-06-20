<?php

class WP_Formalize_Template_Form_Table extends WP_Formalize_Template {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function output( $field, $instance = array() ) {

		// Sets up the output variable.
		$output = '';

		// Opens table row tag.
		$output .= '<tr>';

		// Generates the field label.
		$output .= '<th scope="row">' . $this->generate_label( $instance['args']['label'], $instance['id'] ) . '</th>';

		// Generates the field itself.
		$output .= '<td>' . $field->generate_field( $instance ) . '</td>';

		// Generates the input description.
		$output .= $this->generate_description( $instance['args']['desc'] );

		// Closes table row tag.
		$output .= '</tr>';

		return $output;
	}
}
