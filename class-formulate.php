<?php


class Formulate {

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
	 * Constructor function
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct( $fields = array( 'text' => 'WP_Formulate_Field_Text' ) ) {

		// Loads the base field class file.
		require_once dirname( __FILE__ ) . '/class-field.php';

		// Registers each field supported by default.
		foreach ( $fields as $id => $class_name ) {
			$this->register_field( $id, $class_name );
		}
	}

	/**
	 * Input type registration
	 *
	 * Allows additional input types to be added.
	 *
	 * @since  1.0
	 * @access public
	 * @param  string $id               Unique identifier for this input type.
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

			// Returns the field output.
			return $field->output( $field_settings );
		}

		// formulate_print_r( $this->field_types );
		// $settings = array_replace_recursive( $this->get_default_settings(), $field_settings );
		// formulate_print_r( $settings );


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



	/**
	 * Widget specific form field construction
	 *
	 * @since  1.0
	 * @access public
	 * @param  array  $field_settings Array of input field settings.
	 * @param  object $instance       Instance of current widget object.
	 * @return string                 The form field HTML.
	 */
	public function get_widget_field( $field_settings, $instance ) {

		// Validates the field settings.
		$field_settings = $this->validate_field_settings( $field_settings );

		// Are the field settings valid?
		if ( $field_settings ) {

			// Instantiates the field class.
			$field = new $this->field_types[ $field_settings['type'] ];
			$field_settings = $field->get_field_settings( $field_settings );

			// Prepares the field settings for widget specific usage.
			$field_settings['atts']['id'] = $instance->get_field_id( $field_settings['atts']['id'] );
			$field_settings['atts']['name'] = $instance->get_field_name( $field_settings['atts']['name'] );

			// Returns the field output.
			return $field->output( $field_settings );
		}
	}


}