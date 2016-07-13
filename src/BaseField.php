<?php

namespace ModularWP\Formalize;

abstract class BaseField implements FieldInterface {

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

		// Allows field settings to be modified.
		$settings = \apply_filters( 'formalize_field_settings', $settings, $settings['args']['context'] );

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
			'id'              => '',        // Unique element ID.
			'type'            => 'text',    // Form field type (text, select, textarea, etc.).
			'value'           => '',        // Form field value.
			'atts'            => array(
				  // 'id'     => '',        // Optional. Used if unique element ID and form input ID should not be the same.
				  // 'name'   => '',        // Optional. Used if name and ID of form element should not be the same.
				  // 'class'  => '',        // Optional. CSS class names.
				  // 'value'  => '',        // Optional. The value of the input field.
			),
			'args'            => array(
				'context'     => '',        // Allows settings to be filtered based on context.
				'label'       => '',        // Text to display as the input title/label. (Clicking WILL highlight the related field)
				'title'       => '',        // Text to display as the input title/label. (Clicking WILL NOT highlight the related field)
				'description' => '',        // Optional. Description of form element.
				'size'        => 'default', // The size of the input (small, default, large; default: default).
				'align'       => 'left',    // The alignment of the input (left, right; default: left).
				'before'      => '',        // Custom content to place before the input.
				'after'       => '',        // Custom content to place after the input.
				'template'    => 'default'  // Template to use for field output.
			),
		);

		return $defaults;
	}
}
