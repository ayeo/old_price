<?php
namespace Price\Calculator;

use Price\PriceInterface;

class StandardCalculator
{
	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 */
	public function add(PriceInterface $priceA, PriceInterface $priceB)
	{
		//check currency symbol!
		$priceA->setGross($priceA->getGross() + $priceB->getGross());
		$priceA->setNett($priceA->getNett() + $priceB->getNett());
		
		$tax = 100 * $priceA->getGross() / $priceA->getNett() - 100;
		$priceA->setTax($tax);				
	}

	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 */
	public function substract(PriceInterface $priceA, PriceInterface $priceB)
	{
		//check currency symbol!
		$priceA->setGross($priceA->getGross() - $priceB->getGross());
		$priceA->setNett($priceA->getNett() - $priceB->getNett());

		$tax = 100 * $priceA->getGross() / $priceA->getNett() - 100;
		$priceA->setTax($tax);
	}

	public function multiply(PriceInterface $price, $times)
	{
		$price->setGross($price->getGross() * $times);
		$price->setNett($price->getNett() * $times);

		return $this;
	}


	private function recalculateTax(PriceInterface $price)
	{

	}
}