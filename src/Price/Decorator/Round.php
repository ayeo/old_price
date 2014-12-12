<?php
namespace Price\Decorator;

class Round extends AbstractDecorator
{
	private $precise;
	
	public function __construct($precise)
	{
		$this->precise = $precise;
	}
	
	public function getNett()
	{
		return round($this->price->getNett(), $this->precise);
	}
	
	public function getGross()
	{
		return round($this->price->getGross(), $this->precise);
	}
}