<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 13/07/2016
 * Time: 11:37
 */

namespace ModularWP\Formalize;

interface FieldInterface {
	public function generate_field( $instance = array() );
	public function get_field_settings( $raw_settings );
	public function get_default_settings();
}
