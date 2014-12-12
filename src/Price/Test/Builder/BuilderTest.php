<?php
namespace Price\Test\Builder;

use Price\Builder\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Builder
	 */
	private $builder;

	public function setUp()
	{
		$this->builder = new Builder();
	}

	/**
	 * @dataProvider buildByNettDataProvider
	 */
	public function testBuildByNett($nettValue, $tax, $expectedGross)
	{
		$price = $this->builder->buildByNett($nettValue, $tax);
		$this->assertEquals($expectedGross, $price->getGross());
	}

	public function buildByNettDataProvider()
	{
		return [
			[100, 23, 123],
			[100.00, 23, 123],
			[100.00, 23.00, 123],
			[100.00, 23.00, 123.00],
			[100, 23, 123],
			[99.99, 11, 110.9889],
		];
	}
}