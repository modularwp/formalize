<?php

namespace ModularWP\Formalize\Templates;

use ModularWP\Formalize\Interfaces\FieldInterface;

class Customizer extends Base {

	/**
	 * Outputs the input field
	 *
	 * @param array $instance
	 */
	public function output( $field, $instance = array() ) {

		// Do the option_group and page settings exist?
		if ( !empty( $instance['customizer_api']['section'] ) && !empty( $instance['customizer_api']['wp_customize'] ) ) {

			// Adds the setting to the section.
			$instance['customizer_api']['wp_customize']->add_setting(
				$instance['id'],
				array(
					'default' => '',
				)
			);

			// Adds the control to the setting.
			$instance['customizer_api']['wp_customize']->add_control(
				$instance['id'],
				array(
					'label' => $instance['args']['label'],
					'section' => $instance['customizer_api']['section'],
					'type' => $instance['type'],
				)
			);
		}
	}
}
