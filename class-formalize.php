<?php

// @TODO: determine what form field types should get the 'widefat' class
//        when used in widget forms.
// @TODO: start building the Sanitize class soon so that formatting
//        can work similarly across both classes.
// @TODO: figure out title vs. label for radio/checkboxes
// @TODO: figure out where to handle widget prep (probably shouldn't be in this file)
// @TODO: should templates should be able to determine radio formatting?
// @TODO: figure out how settings work for radio (where is the settings array stored, and where is it applied (radio group, radio buttons etc.))
// @TODO: support default content/state if no value has been saved.

namespace Formalize;

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
			'radio'    => 'WP_Formalize_Field_Radio',
			'select'   => 'WP_Formalize_Field_Select',
			'checkbox' => 'WP_Formalize_Field_Checkbox',
			'textarea' => 'WP_Formalize_Field_Textarea',
			'color'    => 'WP_Formalize_Field_Color',
		);

		// Allows field types to be removed if not needed.
		$fields = apply_filters( 'formalize_fields', $fields );

		// Loads the base field class file.
		require_once dirname( __FILE__ ) . '/fields/class-field.php';

		// Registers each field supported by default.
		foreach ( $fields as $id => $class_name ) {
			$this->register_field( $id, $class_name );
		}

		// Sets up default supported template types.
		$templates = array(
			'default'    => 'WP_Formalize_Template_Default',
			'widget'     => 'WP_Formalize_Template_Widget',
			'settings'   => 'WP_Formalize_Template_Settings',
			'form-table' => 'WP_Formalize_Template_Form_Table',
			'customizer' => 'WP_Formalize_Template_Customizer',
		);

		// Allows template types to be removed if not needed.
		$templates = apply_filters( 'formalize_templates', $templates );

		// Loads the base field class file.
		require_once dirname( __FILE__ ) . '/templates/class-template.php';

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
		$default_file_location = dirname( __FILE__ ) . '/fields/class-field-' . $id . '.php';

		// Does the class file exist in the default location?
		if ( file_exists( $default_file_location ) ) {
			require_once $default_file_location;
		}

		// Is there a class with this class name?
		if ( class_exists( $class_name ) ) {

			// Adds field to field list.
			$this->field_types[$id] = $class_name;

			// Allows the class to enqueue its own files.
			if ( method_exists( $class_name, 'enqueue' ) ) {
				add_action( 'admin_enqueue_scripts', array( $class_name, 'enqueue' ) );
			}
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
		$default_file_location = dirname( __FILE__ ) . '/templates/class-template-' . $id . '.php';

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

		// Prevent errors from incomplete field settings.
		$field_settings = $this->validate_field_settings( $field_settings );

		// Are the field settings valid?
		if ( $field_settings ) {

			// Instatiates the field class.
			$field_object = new $this->field_types[ $field_settings['type'] ];
			$field_settings = $field_object->get_field_settings( $field_settings );

			// Instatiates the template class.
			$template = new $this->template_types[ $field_settings['args']['template'] ];

			// Is this a widget instance?
			if ( !empty( $field_settings['widget_instance'] ) ) {

				// Prepares the field settings for widget specific usage.
				$field_settings['atts']['id'] = $field_settings['widget_instance']->get_field_id( $field_settings['atts']['id'] );
				$field_settings['atts']['name'] = $field_settings['widget_instance']->get_field_name( $field_settings['atts']['name'] );
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
			$output .= $template->output( $field_object, $field_settings );

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
