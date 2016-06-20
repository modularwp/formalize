<?php

class WP_Formalize_Template_Widget extends WP_Formalize_Template {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function output( $field, $instance = array() ) {
		if ( !empty( $instance['atts']['class'] ) ) {
			$instance['atts']['class'] .= ' widefat';
		} else {
			$instance['atts']['class'] = 'widefat';
		}

		// Sets up the output variable.
		$output = '';

		// Opens paragraph tag.
		$output .= '<p>';

		// Generates the field label.
		$output .= $this->generate_label( $instance['args']['label'], $instance['id'] );

		// Generates the field itself.
		$output .= $field->generate_field( $instance );

		// Generates the input description.
		$output .= $this->generate_description( $instance['args']['desc'] );

		// Closes paragraph tag.
		$output .= '<p>';

		return $output;
	}
}
