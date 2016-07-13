<?php

/**
 * Created by PhpStorm.
 * User: gary
 * Date: 13/07/2016
 * Time: 11:56
 */

namespace ModularWP\Formalize;

use PHPUnit_Framework_TestCase;

class TextFieldTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ModularWP\Formalize\TextField::generate_field
	 */
	public function testGenerateFieldReturnsASimpleInputString(  ) {
		// Arrange.
		$text_field = new TextField();

		// Act.
		$field_markup = $text_field->generate_field( [] );
		$expected = '<input type="text">';

		// Assert.
		$this->assertInternalType( 'string', $field_markup );
		$this->assertEquals( $expected, $field_markup );
	}
}
