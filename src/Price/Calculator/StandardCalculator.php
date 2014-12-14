<?php
namespace Price\Calculator;

use Price\Price\Price;
use Price\Price\PriceInterface;

class StandardCalculator implements CalculatorInterface
{
	private $calculateTaxUsingRawValues = true;
	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 * @return PriceInterface
	 */
	public function add(PriceInterface $priceA, PriceInterface $priceB)
	{
		$this->compareCurrencySymbols($priceA, $priceB);

		$rawPriceA = $priceA->getRaw()->cloneMe();
		$rawPriceB = $priceB->getRaw()->cloneMe();

		$priceA->setGross($priceA->getGross() + $priceB->getGross());
		$priceA->setNett($priceA->getNett() + $priceB->getNett());

		if ($this->calculateTaxUsingRawValues AND !($priceA instanceof Price))
		{
			$rawPriceA->setGross($rawPriceA->getGross() + $rawPriceB->getGross());
			$rawPriceA->setNett($rawPriceA->getNett() + $rawPriceB->getNett());
			$this->recalculateTax($rawPriceA);
			$priceA->setTax($rawPriceA->getTax());
		}
		else
		{
			$this->recalculateTax($priceA);
		}

		return $priceA;
	}

	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 * @return PriceInterface
	 */
	public function subtract(PriceInterface $priceA, PriceInterface $priceB)
	{
		$this->compareCurrencySymbols($priceA, $priceB);

		$rawPriceA = $priceA->getRaw()->cloneMe();
		$rawPriceB = $priceB->getRaw()->cloneMe();

		$priceA->setGross($priceA->getGross() - $priceB->getGross());
		$priceA->setNett($priceA->getNett() - $priceB->getNett());

		if ($this->calculateTaxUsingRawValues AND !($priceA instanceof Price))
		{
			$rawPriceA->setGross($rawPriceA->getGross() - $rawPriceB->getGross());
			$rawPriceA->setNett($rawPriceA->getNett() - $rawPriceB->getNett());
			$this->recalculateTax($rawPriceA);
			$priceA->setTax($rawPriceA->getTax());
		}
		else
		{
			$this->recalculateTax($priceA);
		}

		return $priceA;
	}

	/**
	 * @param PriceInterface $price
	 * @param $times
	 * @return PriceInterface
	 */
	public function multiply(PriceInterface $price, $times)
	{
		$price->setGross($price->getGross() * $times);
		$price->setNett($price->getNett() * $times);

		return $price;
	}


	/**
	 * @param PriceInterface $price
	 */
	private function recalculateTax(PriceInterface $price)
	{
		if ($price->getNett() != 0)
		{
			$tax = 100 * $price->getGross() / $price->getNett() - 100;
		}
		else
		{
			$tax = 0;
		}

		$price->setTax($tax);
	}

	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 * @throws \Exception
	 */
	private function compareCurrencySymbols(PriceInterface $priceA, PriceInterface $priceB)
	{
		if ($priceA->getCurrencySymbol() !== $priceB->getCurrencySymbol())
		{
			throw new \Exception('Can not handle different currencies');
		}
	}
}