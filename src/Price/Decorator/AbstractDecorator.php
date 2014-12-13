<?php
namespace Price\Decorator;

use Price\PriceInterface;

abstract class AbstractDecorator implements PriceInterface
{
	/**
	 * @var PriceInterface
	 */
	protected $price;

	private $calculator;

	public function setPrice(PriceInterface $price)
	{
		$this->price = $price;
	}

	final public function setCalculator($calculator)
	{
		$this->calculator = $calculator;
	}

	public function getNett()
	{
		return $this->price->getNett();
	}

	public function getGross()
	{
		return $this->price->getGross();
	}

	public function getTax()
	{
		return $this->price->getTax();
	}

	final public function add(PriceInterface $price)
	{
		$this->calculator->add($this, $price);

		return $this;
	}

	final public function substract(PriceInterface $price)
	{
		$this->calculator->substract($this, $price);

		return $this;
	}

	final public function multiply($times)
	{
		$this->calculator->multiply($this, $times);

		return $this;
	}

	final public function cloneMe()
	{
		return clone($this);
	}

	public function getCurrencySymbol()
	{
		return $this->price->getCurrencySymbol();
	}

	public function setCurrencySymbol($currencySymbol)
	{
		return $this->price->setCurrencySymbol($currencySymbol);
	}

	public function setGross($grossValue)
	{
		$this->price->setGross($grossValue);
	}

	public function setNett($nettValue)
	{
		$this->price->setNett($nettValue);
	}

	public function setTax($tax)
	{
		$this->price->setTax($tax);
	}
}