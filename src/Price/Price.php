<?php
namespace Price;

use Price\Calculator\CalculatorInterface;

class Price implements PriceInterface
{
	/**
	 * @var float
	 */
	private $nettValue;

	/**
	 * @var float
	 */
	private $grossValue;

	/**
	 * @var float
	 */
	private $tax;

	/**
	 * @var null|string
	 */
	private $currencySymbol = null;

	/**
	 * @var CalculatorInterface
	 */
	private $calculator;


	/**
	 * @param CalculatorInterface $calculator
	 */
	public function __construct(CalculatorInterface $calculator)
	{
		$this->calculator = $calculator;
	}

	/**
	 * @param $currencySymbol string|null
	 */
	public function setCurrencySymbol($currencySymbol)
	{
		$this->currencySymbol = $currencySymbol;
	}

	/**
	 * @return string|null
	 */
	public function getCurrencySymbol()
	{
		return $this->currencySymbol;
	}

	/**
	 * @param $nettValue float
	 */
	public function setNett($nettValue)
	{
		$this->nettValue = (float) $nettValue;
	}

	/**
	 * @param $grossValue float
	 */
	public function setGross($grossValue)
	{
		$this->grossValue = (float) $grossValue;
	}

	/**
	 * @param $tax float
	 */
	public function setTax($tax)
	{
		$this->tax = (float) $tax;
	}

	/**
	 * @return float
	 */
	public function getGross()
	{
		return $this->grossValue;
	}

	/**
	 * @return float
	 */
	public function getNett()
	{
		return $this->nettValue;
	}

	/**
	 * @return float
	 */
	public function getTax()
	{
		return $this->tax;
	}

	/**
	 * @param PriceInterface $price
	 * @return PriceInterface
	 */
	public function add(PriceInterface $price)
	{
		return $this->calculator->add($this, $price);
	}

	/**
	 * @param PriceInterface $price
	 * @return PriceInterface
	 */
	public function subtract(PriceInterface $price)
	{
		return $this->calculator->subtract($this, $price);
	}

	/**
	 * @param $times
	 * @return PriceInterface
	 */
	public function multiply($times)
	{
		return $this->calculator->multiply($this, $times);
	}

	/**
	 * @return PriceInterface
	 */
	public function cloneMe()
	{
		return clone($this);
	}

	/**
	 * @return Price
	 */
	final public function getRaw()
	{
		return $this;
	}
}