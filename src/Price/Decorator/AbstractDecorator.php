<?php
namespace Price\Decorator;

use Price\PriceInterface;

abstract class AbstractDecorator implements PriceInterface
{
	/**
	 * @var Price
	 */
	protected $price;

	public function setPrice(PriceInterface $price)
	{
		$this->price = $price;
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

	public function add(PriceInterface $price)
	{
		$this->price->add($price);

		return $this;
	}

	public function cloneMe()
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