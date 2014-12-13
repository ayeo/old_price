<?php
namespace Price\Test\Calculator;

use Price\Builder\Builder;
use Price\Calculator\StandardCalculator;
use Price\Decorator\NoNegative;
use Price\Decorator\Round;

class StandardCalculatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Builder
	 */
	private $builder;

	/**
	 * @var StandardCalculator
	 */
	private $calculator;

	public function setUp()
	{
		$this->builder = new Builder();
		$this->calculator = new StandardCalculator();
	}

	/**
	 * @dataProvider testSubstractionByGrossDataProvider
	 */
	public function testSubstractionByGross($grossA, $taxA, $grossB, $taxB, $expectedGross)
	{
		$priceA = $this->builder->buildByGross($grossA, $taxA);
		$priceB = $this->builder->buildByGross($grossB, $taxB);

		$this->calculator->substract($priceA, $priceB);

		$this->assertEquals($expectedGross, $priceA->getGross());
	}

	public function testSubstractionByGrossDataProvider()
	{
		return [
			[100, 		10, 	150, 		10,		-50],
			[199.99, 	23, 	57.77, 		10,		142.22],
			[199.9988, 	23, 	57.7712, 	10,		142.2276],
		];
	}

	/**
	 * @dataProvider testSubstractionByGrossRoundedDataProvider
	 */
	public function testSubstractionByGrossRounded($grossA, $taxA, $grossB, $taxB, $expectedGross)
	{
		$this->builder->addDecorator(new Round(2));

		$priceA = $this->builder->buildByGross($grossA, $taxA);
		$priceB = $this->builder->buildByGross($grossB, $taxB);

		$this->calculator->substract($priceA, $priceB);

		$this->assertEquals($expectedGross, $priceA->getGross());
	}

	public function testSubstractionByGrossRoundedDataProvider()
	{
		return [
			[100, 		10, 	150, 		10,		-50],
			[199.99, 	23, 	57.77, 		10,		142.22],
			[199.9988, 	23, 	57.7712, 	10,		142.23],
			[10.001, 	23, 	1.002, 		10,		9.00],
			[10.01, 	23, 	1.01, 		10,		9.00],
		];
	}

	/**
	 * @dataProvider testSubstractionByGrossNoNegativeDataProvider
	 */
	public function testSubstractionByGrossNoNegative($grossA, $taxA, $grossB, $taxB, $expectedGross)
	{
		$this->builder->addDecorator(new NoNegative());

		$priceA = $this->builder->buildByGross($grossA, $taxA);
		$priceB = $this->builder->buildByGross($grossB, $taxB);

		$this->calculator->substract($priceA, $priceB);

		$this->assertEquals($expectedGross, $priceA->getGross());
	}

	public function testSubstractionByGrossNoNegativeDataProvider()
	{
		return [
			[100, 		10, 	150, 		10,		0],
			[199.99, 	23, 	200, 		10,		0],
			[200,	 	23, 	199.99, 	10,		0.01],
			[10.001, 	23, 	1.002, 		10,		8.999],
			[10.01, 	23, 	1.01, 		10,		9.00],
		];
	}
}