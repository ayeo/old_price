<?php
namespace Price\Calculator;

use Price\Decorator\AbstractDecorator;
use Price\Price;
use Price\PriceInterface;

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

		$rawA = clone($priceA->getRaw());
		$rawB = clone($priceB->getRaw());

		$priceA->setGross($priceA->getGross() + $priceB->getGross());
		$priceA->setNett($priceA->getNett() + $priceB->getNett());

		if ($this->calculateTaxUsingRawValues AND !($priceA instanceof Price))
		{
			$rawA->add($rawB);
			$this->recalculateTax($rawA);
			$priceA->setTax($rawA->getTax());
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

		$rawA = clone($priceA->getRaw());
		$rawB = clone($priceB->getRaw());

		$priceA->setGross($priceA->getGross() - $priceB->getGross());
		$priceA->setNett($priceA->getNett() - $priceB->getNett());

		if ($this->calculateTaxUsingRawValues AND !($priceA instanceof Price))
		{
			$rawA->subtract($rawB);
			$this->recalculateTax($rawA);
			$priceA->setTax($rawA->getTax());
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