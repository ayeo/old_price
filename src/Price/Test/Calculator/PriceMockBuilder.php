<?php
namespace Price\Test\Calculator;

use Price\Decorator\Round;
use Price\Price\Price;

class PriceMockBuilder extends Price
{
	private $decorator;

	public function __construct($round = null)
	{
		if (!is_null($round))
		{
			$this->decorator = new Round($round);
		}
	}

	public function build($nett = null, $gross = null, $tax = null)
	{
		$price = new PriceMock($nett, $gross, $tax);

		if ($this->decorator)
		{
			$decorator = clone($this->decorator);
			$decorator->setPrice($price);

			return $decorator;
		}

		return $price;


	}
}