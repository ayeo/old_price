<?php
namespace Price\Calculator;

use Price\PriceInterface;

interface CalculatorInterface
{
	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 * @return PriceInterface
	 */
	public function add(PriceInterface $priceA, PriceInterface $priceB);

	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 * @return PriceInterface
	 */
	public function subtract(PriceInterface $priceA, PriceInterface $priceB);

	/**
	 * @param PriceInterface $price
	 * @param $times
	 * @return PriceInterface
	 */
	public function multiply(PriceInterface $price, $times);
}