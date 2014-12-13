<?php
namespace Price\Decorator;

class ConvertCurrency extends AbstractDecorator
{
	private $rates = [];

	private $currencySymbol;

	public function __construct($currencySymbol, $rates = [])
	{
		$this->currencySymbol = $currencySymbol;
		$this->rates = $rates;
	}

	/**
	 * @return float
	 */
	public function getNett()
	{
		return $this->price->getNett() / $this->rates[$this->price->getCurrencySymbol()] * $this->rates[$this->currencySymbol];
	}

	/**
	 * @return float
	 */
	public function getGross()
	{
		return $this->price->getGross() / $this->rates[$this->price->getCurrencySymbol()] * $this->rates[$this->currencySymbol];
	}

	public function setGross($grossValue)
	{
		$this->price->setGross($grossValue * $this->rates[$this->price->getCurrencySymbol()] / $this->rates[$this->currencySymbol]);
	}

	public function setNett($nettValue)
	{
		$this->price->setNett($nettValue * $this->rates[$this->price->getCurrencySymbol()] / $this->rates[$this->currencySymbol]);
	}

	/**
	 * @return null|string
	 */
	public function getCurrencySymbol()
	{
		return $this->currencySymbol;
	}
}