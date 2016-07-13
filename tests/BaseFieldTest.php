<?php

/**
 * Created by PhpStorm.
 * User: gary
 * Date: 13/07/2016
 * Time: 11:56
 */

namespace ModularWP\Formalize;

use PHPUnit_Framework_TestCase;

class BaseFieldTest extends PHPUnit_Framework_TestCase {
	public function testTestsAreWorking() {
		$this->assertTrue( true );
	}

	/**
	 * @covers ModularWP\Formalize\BaseField::get_default_settings
	 */
	public function testGetDefaultSettingsReturnsAnArray(  ) {
		// Arrange.
		$base_field = new ConcreteBaseField();

		// Act.
		$default_settings = $base_field->get_default_settings();

		// Assert.
		$this->assertInternalType( 'array', $default_settings );
	}
}

class ConcreteBaseField extends BaseField {
	public function generate_field( $instance = [ ] ) {}
}
