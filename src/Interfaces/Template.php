<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 13/07/2016
 * Time: 11:37
 */

namespace ModularWP\Formalize\Interfaces;

use ModularWP\Formalize\FieldInterface;

interface Template {
	public function output( FieldInterface $field, $instance = array() );
}
