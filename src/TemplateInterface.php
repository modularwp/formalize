<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 13/07/2016
 * Time: 11:37
 */

namespace ModularWP\Formalize;

interface TemplateInterface {
	public function output( $field, $instance = array() );
}
