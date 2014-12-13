<?php
namespace Price\Calculator;

use Price\PriceInterface;

interface CalculatorInterface
{
	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 */
	public function add(PriceInterface $priceA, PriceInterface $priceB);

	/**
	 * @param PriceInterface $priceA
	 * @param PriceInterface $priceB
	 */
	public function substract(PriceInterface $priceA, PriceInterface $priceB);

	/**
	 * @param PriceInterface $price
	 * @param $times
	 */
	public function multiply(PriceInterface $price, $times);
}