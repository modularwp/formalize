<?php

namespace ModularWP\Formalize\Templates;

use ModularWP\Formalize\Interfaces\FieldInterface;

class Settings extends Base {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function output( $field, $instance = array() ) {

		// Do the option_group and page settings exist?
		if ( !empty( $instance['settings_api']['option_group'] ) && !empty( $instance['settings_api']['page'] ) ) {

			// Is a sanitization callback function specified?
			if ( empty( $instance['settings_api']['sanitize_callback'] ) ) {
				$instance['settings_api']['sanitize_callback'] = '';
			}

			// Register the setting.
			register_setting(
				$instance['settings_api']['option_group'],
				$instance['id'],
				$instance['settings_api']['sanitize_callback']
			);

			// Add a field to the registered setting.
			add_settings_field(
				$instance['id'],
				$instance['args']['label'],
				function() use ( $field, $instance ) {
					echo $field->generate_field( $instance );
					echo $this->generate_description( $instance['args']['description'] );
				},
				$instance['settings_api']['page'],
				$instance['settings_api']['option_group']
			);
		}
	}
}

