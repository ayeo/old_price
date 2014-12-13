<?php
namespace Price\Builder;

use Price\Calculator\StandardCalculator;
use Price\Calculator\CalculatorInterface;
use Price\Decorator\AbstractDecorator;
use Price\Price;
use Price\PriceInterface;

class Builder
{
	private $currencySymbol;
	
	private $decorators = [];

	/**
	 * @var CalculatorInterface
	 */
	private $calculator;


	public function __construct()
	{
		$this->calculator = new StandardCalculator();
	}

	public function addDecorator(AbstractDecorator $decorator)
	{
		$this->decorators[] = $decorator;
	}
	
	public function setCurrencySymbol($currencySymbol)
	{
		$this->currencySymbol = $currencySymbol;
		
		return $this;
	}
	
	public function buildByNett($nettValue, $tax)
	{
		$grossValue = $nettValue * (1 + $tax / 100);
		
		return $this->build($nettValue, $grossValue, $tax);
	}
	
	public function buildByGross($grossValue, $tax)
	{
		$nettValue = $grossValue / (1 + $tax / 100);
		
		return $this->build($nettValue, $grossValue, $tax);
	}
	
	private function build($nettValue, $grossValue, $tax)
	{
		$price = new Price($this->calculator);
		$price->setNett($nettValue);
		$price->setGross($grossValue);
		$price->setTax($tax);
		$price->setCurrencySymbol($this->currencySymbol);
		
		foreach ($this->decorators as $decorator)
		{
			$price = $this->decorate($price, $decorator);
		}
		
		return $price;
	}

	/**
	 * @param PriceInterface $price
	 * @param AbstractDecorator $decorator
	 * @return PriceInterface
	 */
	public function decorate(PriceInterface $price, AbstractDecorator $decorator)
	{
		$clone = clone($decorator);
		$clone->setPrice($price);
		$clone->setCalculator($this->calculator);

		return $clone;
	}
	
}