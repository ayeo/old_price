<?php
namespace Price;

use Price\Calculator\StandardCalculator;

class Price implements PriceInterface
{
	private $nettValue;
	
	private $grossValue;
	
	private $tax;
	
	private $currencySymbol = null;
	
	private $calculator;

	
	public function __construct(StandardCalculator $calculator)
	{
		$this->calculator = $calculator;
	}
	
	public function setCurrencySymbol($currencySymbol)
	{
		$this->currencySymbol = $currencySymbol;
	}
	
	public function setNett($nettValue)
	{
		$this->nettValue = $nettValue;
	}
	
	public function setGross($grossValue)
	{
		$this->grossValue = $grossValue;
	}
	
	public function setTax($tax)
	{
		$this->tax = $tax;
	}
	
	public function getGross()
	{
		return $this->grossValue;
	}

	public function getNett()
	{
		return $this->nettValue;
	}

	public function getTax()
	{
		return $this->tax;
	}	
	
	public function getCurrencySymbol()
	{
		return $this->currencySymbol;
	}
	
	public function add(PriceInterface $price)
	{
		$this->calculator->add($this, $price);
		
		return $this;
	}
	
	public function cloneMe()
	{
		return clone($this);
	}
}