<?php
namespace Price;

interface PriceInterface
{
	/**
	 * @param $currencySymbol null|string
	 */
	public function setCurrencySymbol($currencySymbol);

	/**
	 * @param $nettValue float
	 */
	public function setNett($nettValue);

	/**
	 * @param $grossValue float
	 */
	public function setGross($grossValue);

	/**
	 * @param $tax float
	 */
	public function setTax($tax);

	/**
	 * @return float
	 */
	public function getGross();

	/**
	 * @return float
	 */
	public function getNett();

	/**
	 * @return float
	 */
	public function getTax();

	/**
	 * @return null|string
	 */
	public function getCurrencySymbol();

	/**
	 * @param PriceInterface $price
	 * @return PriceInterface
	 */
	public function add(PriceInterface $price);

	/**
	 * @param PriceInterface $price
	 * @return PriceInterface
	 */
	public function subtract(PriceInterface $price);

	/**
	 * @param $times
	 * @return PriceInterface
	 */
	public function multiply($times);

	/**
	 * @return PriceInterface
	 */
	public function cloneMe();
}