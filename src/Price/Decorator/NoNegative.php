<?php
namespace Price\Decorator;

class NoNegative extends AbstractDecorator
{
	/**
	 * @return float
	 */
	public function getNett()
	{
		if ($this->price->getNett() >= 0)
		{
			return $this->price->getNett();
		}
		else
		{
			return 0.00;
		}
	}

	/**
	 * @return float
	 */
	public function getGross()
	{
		if ($this->price->getGross() >= 0)
		{
			return $this->price->getGross();
		}
		else
		{
			return 0.00;
		}

	}
}