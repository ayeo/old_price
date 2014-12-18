<?php
namespace Price\Price;

use Price\Calculator\CalculatorInterface;

class Price extends AbstractPrice implements PriceInterface
{
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


}