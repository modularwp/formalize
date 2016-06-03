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
	 * @param  array  $field_settings   Array of input field settings.
	 * @return string                   The input field HTML.
	 */
	public function get_field( $field_settings ) {

		// Has a field type been set?
		if ( empty( $field_settings['type'] ) ) {

			// Sets the default field type to "text".
			$field_settings['type'] = 'text';
		}

		// formulate_print_r( $this->field_types );
		// $settings = array_replace_recursive( $this->get_default_settings(), $field_settings );
		// formulate_print_r( $settings );

		// Has the field type been registered?
		if ( array_key_exists( $field_settings['type'], $this->field_types ) ) {

			// Does a class exist for this field type?
			if ( class_exists( $this->field_types[ $field_settings['type'] ] ) ) {

				// Instatiates the field class.
				$field = new $this->field_types[ $field_settings['type'] ];

				// Returns the field output.
				return $field->output( $field_settings );
			}
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


}