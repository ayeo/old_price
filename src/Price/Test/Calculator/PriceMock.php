<?php
namespace Price\Test\Calculator;

use Price\Price\Price;

class PriceMock extends Price
{
	public function __construct($nett = null, $gross = null, $tax = null)
	{
		if (!$nett)
		{
			$nett = $gross / (1 + $tax / 100);
		}

		if (!$gross)
		{
			$gross = $nett * (1 + $tax / 100);
		}

		$this->setGross($gross);
		$this->setNett($nett);
		$this->setTax($tax);
	}
}