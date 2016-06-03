<?php

class WP_Formulate_Field {

	/**
	 * Merges the arguments array with the defaults array.
	 *
	 * @since  1.0
	 * @param  array $raw_settings The initial array of arguments to use when creating the form element.
	 * @return array $settings     The array of initial arguments parsed with the defaults.
	 */
	public function get_field_settings( $raw_settings ) {
		$settings = array_replace_recursive( $this->get_default_settings(), $raw_settings );

		// Set the form input ID if empty.
		if ( empty( $settings['atts'][ 'id' ] ) ) {
			$settings['atts'][ 'id' ] = $settings[ 'id' ];
		}

		// Set the form input name if empty.
		if ( empty( $settings['atts'][ 'name' ] ) ) {
			$settings['atts'][ 'name' ] = $settings[ 'id' ];
		}

		return $settings;
	}

	/**
	 * Gets default field settings
	 *
	 * @since  1.0
	 * @return array $defaults The array of default input settings.
	 */
	public function get_default_settings() {
		$defaults = array(
			'id'         => '',        // Unique element ID.
			'type'       => 'text',
			'atts' => array(
				// 'id'     => '',        // Optional. Used if unique element ID and form input ID should not be the same.
				// 'name'   => '',        // Optional. Used if name and ID of form element should not be the same.
				// 'class'  => '',        // Optional. CSS class names.
				// 'value'  => '',        // Optional. The value of the input field.
			),
			'args'   => array(
				'label'  => '',        // Text to display as the input title/label.
				'desc'   => '',        // Optional. Description of form element.
				'size'   => 'default', // The size of the input (small, default, large; default: default).
				'align'  => 'left',    // The alignment of the input (left, right; default: left).
				'before' => '',        // Custom content to place before the input.
				'after'  => '',        // Custom content to place after the input.
			),
		);

		return $defaults;
	}

	/**
	 * Displays the label for a form element
	 *
	 * @since  1.0
	 * @param  string $label The text to display in the label.
	 * @param  string $id    ID of the form element to which this label belongs.
	 * @return string        The HTML label element.
	 */
	public function get_label( $label = '', $id = '' ) {

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
	public function get_description( $desc = '' ) {

		// Is there a description?
		if ( $desc ) {
			return ' <p class="description">' . $desc . '</p>';
		}
	}
}
