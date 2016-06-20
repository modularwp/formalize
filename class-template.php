<?php

class WP_Formalize_Template {

	/**
	 * Displays the label for a form element
	 *
	 * @since  1.0
	 * @param  string $label The text to display in the label.
	 * @param  string $id    ID of the form element to which this label belongs.
	 * @return string        The HTML label element.
	 */
	public function generate_label( $label = '', $id = '' ) {

		// Is there a label?
		if ( $label ) {
			return '<label for="' . $id . '">' . $label . '</label>';
		}
	}

	/**
	 * Generates a form element description
	 *
	 * @since 1.0
	 * @param string $desc Text to display in the description.
	 * @return string The description string formatted as a paragraph.
	 */
	public function generate_description( $desc = '' ) {

		// Is there a description?
		if ( $desc ) {
			return ' <p class="description">' . $desc . '</p>';
		}
	}
}
