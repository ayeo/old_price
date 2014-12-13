<?php
namespace Price\Test\Builder;

use Price\Builder\Builder;
use Price\Decorator\Round;

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
			[100,			23,			123.00],
			[100.00,		23,			123.00],
			[100.00,		23.00,		123.00],
			[100.00,		23.00,		123.00],
			[100,			23,			123],

			[99.99,			11,			110.9889],
		];
	}

	public function testBuildByString()
	{
		$price = $this->builder->buildByNett('test', 1);
		$this->assertEquals(0.00, $price->getGross());
		$this->assertEquals(0.00, $price->getNett());
		$this->assertEquals(1.00, $price->getTax());
	}

	public function testBuildByTaxString()
	{
		$price = $this->builder->buildByNett(100, 'test');
		$this->assertEquals(100.00, $price->getGross());
		$this->assertEquals(100.00, $price->getNett());
		$this->assertEquals(0.00, $price->getTax());
	}
}