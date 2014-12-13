<?php
namespace Price\Test\Calculator;

use Price\Builder\Builder;
use Price\Calculator\StandardCalculator;
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
	 * @dataProvider testSubtractionByGrossRoundedDataProvider
	 */
	public function testSubtractionByGrossRounded($round, $grossA, $taxA, $grossB, $taxB, $expectedGross, $expectedNett, $expectedTax)
	{
		$delta = 0.000000001;

		$builder = new PriceMockBuilder($round);
		$priceA = $builder->build(null, $grossA, $taxA);
		$priceB = $builder->build(null, $grossB, $taxB);

		$this->calculator->subtract($priceA, $priceB);

		$this->assertEquals($expectedGross,	$priceA->getGross(),	'', $delta);
		$this->assertEquals($expectedNett,	$priceA->getNett(),		'', $delta);
		$this->assertEquals($expectedTax,	$priceA->getTax(),		'', $delta);
	}

	public function testSubtractionByGrossRoundedDataProvider()
	{
		return
		[
			[null,	100, 		10, 	150, 		10,		-50,		-45.4545454545,		10],
			[1,		100, 		10, 	150, 		10,		-50,		-45.5,				10],
			[2,		100, 		10, 	150, 		10,		-50,		-45.45,				10],
			[3,		100, 		10, 	150, 		10,		-50,		-45.455,			10],
			[4,		100, 		10, 	150, 		10,		-50,		-45.4545,			10],

			[null,	199.99, 	23, 	57.77, 		10,		142.22,		110.075314117,		29.2024475616],
			[0,		199.99, 	23, 	57.77, 		10,		142.00,		110.00,				29.2024475616],
			[1,		199.99, 	23, 	57.77, 		10,		142.20,		110.10,				29.2024475616],
			[2,		199.99, 	23, 	57.77, 		10,		142.22,		110.07,				29.2024475616],
			[3,		199.99, 	23, 	57.77, 		10,		142.22,		110.075,			29.2024475616],
			[4,		199.99, 	23, 	57.77, 		10,		142.22,		110.0753,			29.2024475616],

			[null,	199.9988, 	23, 	57.7712, 	10,		142.2276,	110.081377679,		29.2022347453],
			[0,		199.9988, 	23, 	57.7712, 	10,		142.00,		110.00,				29.2022347453],
			[1,		199.9988, 	23, 	57.7712, 	10,		142.20,		110.10,				29.2022347453],
			[2,		199.9988, 	23, 	57.7712, 	10,		142.23,		110.08,				29.2022347453],
			[8, 	199.9988, 	23, 	57.7712, 	10,		142.2276,	110.08137768,		29.2022347453],

			[2,		10.001, 	23, 	1.002, 		10,		9.00,		7.22,				24.6401443804],
			[2,		10.01, 		23, 	1.01, 		10,		9.00,		7.22,				24.6532291912],

			[0,		40.4444, 	23, 	29.9983, 	10,		10.00,		6.00,				86.1902486006],

			[null,	11.1123, 	23, 	29.9983, 	10,		-18.886,	-18.2367915743,		3.55988290526],
			[0,		11.1123, 	23, 	29.9983, 	10,		-19.00,		-18,				3.55988290526],
			[1,		11.1123, 	23, 	29.9983, 	10,		-18.90,		-18.30,				3.55988290526],
			[2,		11.1123, 	23, 	29.9983, 	10,		-18.89,		-18.24,				3.55988290526],
			[3,		11.1123, 	23, 	29.9983, 	10,		-18.886,	-18.237,			3.55988290526],

			[null,	17.23672,	11.54, 	2.12342,	11.54,	15.1133,	13.5496682804,		11.54],
			[0,		17.23672,	11.54, 	2.12342,	11.54,	15.00,		13.00,				11.54],
			[1,		17.23672,	11.54, 	2.12342,	11.54,	15.10,		13.60,				11.54],
			[2,		17.23672,	11.54, 	2.12342,	11.54,	15.12,		13.55,				11.54],
			[3,		17.23672,	11.54, 	2.12342,	11.54,	15.114,		13.549,				11.54],
			[4,		17.23672,	11.54, 	2.12342,	11.54,	15.1133,	13.5497,			11.54],

			[null,	10.00,		10,	 	10.00,		10,		0.00,		0.00,				0.00], // 0 Nett
		];
	}


	/**
	 * @dataProvider testAddingDataProvider
	 */
	public function testAdding($round, $taxA, $nettA, $taxB, $nettB, $expectedNett, $expectedGross, $expectedTax)
	{
		$builder = new PriceMockBuilder($round);
		$priceA = $builder->build($nettA, null, $taxA);
		$priceB = $builder->build($nettB, null, $taxB);

		$this->calculator->add($priceA, $priceB);

		$this->assertEquals($expectedGross, $priceA->getGross());
		$this->assertEquals($expectedNett, $priceA->getNett());
		$this->assertEquals($expectedTax, $priceA->getTax());
	}

	public function testAddingDataProvider()
	{
		return [
			[2,		23,		100,		23,		100,		200,		246,		23],
			[2,		23,		99.99,		23,		87.87,		187.86,		231.07,		23],
			[null,	23,		99.99,		23,		87.87,		187.86,		231.0678,	23],

			[null,	19.11,	56.11543,	19.11,	11.73822,	67.85365,	80.820482515,	19.11],
			[0,		19.11,	56.11543,	19.11,	11.73822,	68.00,		81.00,			19.11],
			[2,		19.11,	56.11543,	19.11,	11.73822,	67.86,		80.82,			19.11],

			[2,		0,		1.0444,		0,		1.0444,		2.08,		2.08,			0],
			[0,		0,		1.0444,		0,		1.0444,		2.00,		2.00,			0],
			[null,	0,		1.0444,		0,		1.0444,		2.0888,		2.0888,			0],

			[null,		23,		100,		10,		100,		200,		233,		16.50],

			[null,		10.00,	67.1512,	10.00,	13.1145,	80.2657,		88.29227,		10.00],
			[1,			10.00,	67.1512,	10.00,	13.1145,	80.3000,		88.30000,		10.00],
			[2,			10.00,	67.1512,	10.00,	13.1145,	80.2600,		88.30000,		10.00],


			[null,		10.00,	10.1144,	10.00,	10.1144,	20.2288,		22.25168,		10.00],
			[0,			10.00,	10.1144,	10.00,	10.1144,	20.0000,		22.00000,		10.00],
			[1,			10.00,	10.1144,	10.00,	10.1144,	20.2000,		22.20000,		10.00],
			[2,			10.00,	10.1144,	10.00,	10.1144,	20.2200,		22.26000,		10.00], // gross: 11,12584 => 2 * 11,13 = 22,26
		];
	}
}