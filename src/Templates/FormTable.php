<?php

namespace ModularWP\Formalize\Templates;

use ModularWP\Formalize\Interfaces\FieldInterface;

class FormTable extends Base {

	/**
	 * Outputs the input field
	 *
	 * @param array $field_settings
	 */
	public function output( $field_object, $field_settings = array() ) {

		// Sets up the output variable.
		$output = '';

		// Opens table row tag.
		$output .= '<tr>';

		// Generates the field label.
		$output .= '<th scope="row">';

		if ( $field_settings['args']['title'] ) {
			$output .= wp_kses_post( $field_settings['args']['title'] );
		} else {
			$output .= $this->generate_label( $field_settings['args']['label'], $field_settings['id'] );
		}
		$output .= '</th>';

		// Generates the field and description.
		$output .= '<td>';
		$output .= $field_object->generate_field( $field_settings );
		$output .= $this->generate_description( $field_settings['args']['description'] );
		$output .= '</td>';

		// Closes table row tag.
		$output .= '</tr>';

		return $output;
	}
}
