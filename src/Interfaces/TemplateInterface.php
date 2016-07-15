<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 13/07/2016
 * Time: 11:37
 */

namespace ModularWP\Formalize\Interfaces;

use ModularWP\Formalize\Interfaces\FieldInterface;

interface TemplateInterface {
	public function output( FieldInterface $field, $instance = array() );
}
