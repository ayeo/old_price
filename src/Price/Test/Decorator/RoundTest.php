<?php
namespace Price\Test\Decorator;

use Price\Test\Calculator\PriceMockBuilder;

class RoundTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider dataProvider
	 */
	public function testRounding($round, $gross, $tax, $expectedGross)
	{
		$builder = new PriceMockBuilder($round);
		$price = $builder->build(null, $gross, $tax);

		$this->assertEquals($expectedGross, $price->getGross());

	}

	public function dataProvider()
	{
		return
		[
			[null,		99.99,		23.00,		99.99],
			[0,			99.99,		23.00,		100.00],
			[1,			99.99,		23.00,		100.00],
			[2,			99.99,		23.00,		99.99],

		];
	}
}