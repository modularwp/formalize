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
	public function setUp() {
		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
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

	/**
	 * @covers ModularWP\Formalize\BaseField::get_field_settings
	 * @covers ModularWP\Formalize\BaseField::get_default_settings
	 */
	public function testGetFieldSettingsReturnsAnArray(  ) {
		// Arrange.
		\WP_Mock::wpPassthruFunction( 'apply_filters' );

		$base_field = new ConcreteBaseField();

		// Act.
		$field_settings = $base_field->get_field_settings( [] );

		// Assert.
		$this->assertInternalType( 'array', $field_settings );
	}
}

class ConcreteBaseField extends BaseField {
	public function generate_field( $instance = [ ] ) {}
}
