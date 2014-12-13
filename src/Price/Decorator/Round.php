<?php
namespace Price\Decorator;

class Round extends AbstractDecorator
{
	/**
	 * @var int
	 */
	private $precise;

	/**
	 * @param $precise integer
	 */
	public function __construct($precise)
	{
		$this->precise = $precise;
	}

	/**
	 * @return float
	 */
	public function getNett()
	{
		return round($this->price->getNett(), $this->precise);
	}

	/**
	 * @return float
	 */
	public function getGross()
	{
		return round($this->price->getGross(), $this->precise);
	}
}