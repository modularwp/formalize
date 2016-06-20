<?php

// @TODO: determine what form field types should get the 'widefat' class
//        when used in widget forms.
// @TODO: start building the Sanitize class soon so that formatting
//        can work similarly across both classes.
// @TODO: support "value" for elements that don't include it as an attribute

class Formalize {

	/**
	 * Field types
	 *
	 * Holds an array of all registered field types.
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $field_types;

	/**
	 * Template types
	 *
	 * Holds an array of all registered template types.
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $template_types;

	/**
	 * Constructor function
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {

		// Sets up default supported field types.
		$fields = array(
			'text'     => 'WP_Formalize_Field_Text',
			'textarea' => 'WP_Formalize_Field_Textarea',
		);

		// Allows field types to be removed if not needed.
		$fields = apply_filters( 'formalize_fields', $fields );

		// Loads the base field class file.
		require_once dirname( __FILE__ ) . '/class-field.php';

		// Registers each field supported by default.
		foreach ( $fields as $id => $class_name ) {
			$this->register_field( $id, $class_name );
		}

		// Sets up default supported template types.
		$templates = array(
			'default'    => 'WP_Formalize_Template_Default',
			'widget'     => 'WP_Formalize_Template_Widget',
			'form-table' => 'WP_Formalize_Template_Form_Table',
		);

		// Allows template types to be removed if not needed.
		$templates = apply_filters( 'formalize_templates', $templates );

		// Loads the base field class file.
		require_once dirname( __FILE__ ) . '/class-template.php';

		// Registers each field supported by default.
		foreach ( $templates as $id => $class_name ) {
			$this->register_template( $id, $class_name );
		}
	}

	/**
	 * Field type registration
	 *
	 * Allows additional field types to be added.
	 *
	 * @since  1.0
	 * @access public
	 * @param  string $id         Unique identifier for this input type.
	 * @param  string $class_name Name of class that handles this input type.
	 */
	public function register_field( $id, $class_name ) {

		// Defines the expected location of the class file. Not required. Can be included manually.
		$default_file_location = dirname( __FILE__ ) . '/class-field-' . $id . '.php';

		// Does the class file exist in the default location?
		if ( file_exists( $default_file_location ) ) {
			require_once $default_file_location;
		}

		// Is there a class with this class name?
		if ( class_exists( $class_name ) ) {
			$this->field_types[$id] = $class_name;
		}
	}

	/**
	 * Template registration
	 *
	 * Allows additional templates to be added.
	 *
	 * @since  1.0
	 * @access public
	 * @param  string $id         Unique identifier for this input type.
	 * @param  string $class_name Name of class that handles this input type.
	 */
	public function register_template( $id, $class_name ) {

		// Defines the expected location of the class file. Not required. Can be included manually.
		$default_file_location = dirname( __FILE__ ) . '/class-template-' . $id . '.php';

		// Does the class file exist in the default location?
		if ( file_exists( $default_file_location ) ) {
			require_once $default_file_location;
		}

		// Is there a class with this class name?
		if ( class_exists( $class_name ) ) {
			$this->template_types[$id] = $class_name;
		}
	}

	/**
	 * Form field construction
	 *
	 * @since  1.0
	 * @access public
	 * @param  array  $field_settings Array of input field settings.
	 * @return string                 The form field HTML.
	 */
	public function get_field( $field_settings ) {
		$field_settings = $this->validate_field_settings( $field_settings );

		// Are the field settings valid?
		if ( $field_settings ) {

			// Instatiates the field class.
			$field = new $this->field_types[ $field_settings['type'] ];
			$field_settings = $field->get_field_settings( $field_settings );

			// Instatiates the template class.
			$template = new $this->template_types[ $field_settings['args']['template'] ];

			if ( !empty( $field_settings['widget_instance'] ) ) {

				// Prepares the field settings for widget specific usage.
				$field_settings['atts']['id'] = $field_settings['widget_instance']->get_field_id( $field_settings['atts']['id'] );
				$field_settings['atts']['name'] = $field_settings['widget_instance']->get_field_name( $field_settings['atts']['name'] );

				// Adds 'widefat' class to widget inputs
				// if ( empty( $field_settings['atts']['class'] ) ) {
				// 	$field_settings['atts']['class'] = 'widefat';
				// }

				// Adds paragraph tags around form fields to match default widget form structure.
				$field_settings['args']['before'] = isset( $field_settings['args']['before'] ) ? '<p>' . $field_settings['args']['before'] : '<p>';
				$field_settings['args']['after']  = isset( $field_settings['args']['after'] )  ? $field_settings['args']['after'] . '</p>' : '</p>';
			}

			// Sets up the field output.
			$output = '';

			// Is there anything to output before the form field?
			if ( $field_settings['args']['before'] ) {
				$output .= $field_settings['args']['before'];
			}

			// Generates the form field.
			// $output .= $field->get_label($field_settings['args']['label'], $field_settings['id'] );
			// $output .= $field->output( $field_settings );
			$output .= $template->output( $field, $field_settings );

			// Is there anything to output after the form field?
			if ( $field_settings['args']['after'] ) {
				$output .= $field_settings['args']['after'];
			}

			return $output;
		}
	}

	/**
	 * Form field display
	 *
	 * @since  1.0
	 * @access public
	 * @param  array  $field_settings Array of input field settings.
	 */
	public function field( $field_settings ) {

		// Displays the field output.
		echo $this->get_field( $field_settings );
	}

	/**
	 * Validates field settigs
	 *
	 * This function should be called before attempting to display a form
	 * field to ensure that field settings are valid.
	 *
	 * @since  1.0
	 * @access public
	 * @param  array      $field_settings Array of input field settings.
	 * @return array/bool $field_settings Array of normalized input field settings.
	 */
	public function validate_field_settings( $field_settings ) {

		// Has a field type been set?
		if ( empty( $field_settings['type'] ) ) {
			return false;
		}

		// Has the field type been registered?
		if ( ! array_key_exists( $field_settings['type'], $this->field_types ) ) {
			return false;
		}

		// Does a class exist for this field type?
		if ( ! class_exists( $this->field_types[ $field_settings['type'] ] ) ) {
			return false;
		}

		// Returns the field settings.
		return $field_settings;
	}
}
