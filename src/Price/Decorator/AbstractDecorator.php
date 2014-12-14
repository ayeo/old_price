<?php
namespace Price\Decorator;

use Price\Calculator\CalculatorInterface;
use Price\Price\PriceInterface;

abstract class AbstractDecorator implements PriceInterface
{
	/**
	 * @var PriceInterface
	 */
	protected $price;

	/**
	 * @var CalculatorInterface
	 */
	private $calculator;

	/**
	 * @param PriceInterface $price
	 */
	final public function setPrice(PriceInterface $price)
	{
		$this->price = $price;
	}

	/**
	 * @param PriceInterface $price
	 * @return PriceInterface
	 */
	final public function add(PriceInterface $price)
	{
		return $this->calculator->add($this, $price);
	}

	/**
	 * @param \Price\Price\PriceInterface $price
	 * @return PriceInterface
	 */
	final public function subtract(PriceInterface $price)
	{
		return $this->calculator->subtract($this, $price);
	}

	/**
	 * @param $times
	 * @return PriceInterface
	 */
	final public function multiply($times)
	{
		return $this->calculator->multiply($this, $times);
	}

	/**
	 * @param CalculatorInterface $calculator
	 */
	final public function setCalculator(CalculatorInterface $calculator)
	{
		$this->calculator = $calculator;
	}

	/**
	 * @return float
	 */
	public function getNett()
	{
		return $this->price->getNett();
	}

	/**
	 * @return float
	 */
	public function getGross()
	{
		return $this->price->getGross();
	}

	/**
	 * @return float
	 */
	public function getTax()
	{
		return $this->price->getTax();
	}

	/**
	 * @return \Price\Price\PriceInterface
	 */
	final public function cloneMe()
	{
		return clone($this);
	}

	/**
	 * @return null|string
	 */
	public function getCurrencySymbol()
	{
		return $this->price->getCurrencySymbol();
	}

	/**
	 * @param null|string $currencySymbol
	 */
	public function setCurrencySymbol($currencySymbol)
	{
		return $this->price->setCurrencySymbol($currencySymbol);
	}

	/**
	 * @param float $grossValue
	 */
	public function setGross($grossValue)
	{
		$this->price->setGross($grossValue);
	}

	/**
	 * @param float $nettValue
	 */
	public function setNett($nettValue)
	{
		$this->price->setNett($nettValue);
	}

	/**
	 * @param float $tax
	 */
	public function setTax($tax)
	{
		$this->price->setTax($tax);
	}

	/**
	 * @return PriceInterface
	 */
	final public function getRaw()
	{
		return $this->price->getRaw();
	}
}