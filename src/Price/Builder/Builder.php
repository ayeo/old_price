<?php
namespace Price\Builder;

use Price\Builder\Config\ConfigInterface;
use Price\Builder\Config\StandardConfig;
use Price\Calculator\CalculatorInterface;
use Price\Decorator\AbstractDecorator;
use Price\Price\Price;
use Price\Price\PriceInterface;

class Builder implements BuilderInterface
{
    /**
     * @var string|null
     */
    private $currencySymbol;

    /**
     * @var array
     */
    private $decorators = [];

    /**
     * @var CalculatorInterface
     */
    private $calculator;


    public function __construct(ConfigInterface $config = null)
    {
        if (is_null($config))
        {
            $config = new StandardConfig();
        }

        $this->calculator = $config->getCalculator();
        $this->decorators = $config->getDecorators();
        $this->setCurrencySymbol($config->getCurrencySymbol());
    }

    /**
     * @param AbstractDecorator $decorator
     */
    public function addDecorator(AbstractDecorator $decorator)
    {
        $this->decorators[] = $decorator;
    }

    /**
     * @param $currencySymbol string
     * @return $this
     */
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;

        return $this;
    }

    /**
     * @param $nettValue float
     * @param $tax float
     * @return PriceInterface
     */
    public function buildByNett($nettValue, $tax)
    {
        $grossValue = $nettValue * (1 + $tax / 100);

        return $this->build($nettValue, $grossValue, $tax);
    }

    /**
     * @param $grossValue float
     * @param $tax float
     * @return PriceInterface
     */
    public function buildByGross($grossValue, $tax)
    {
        $nettValue = $grossValue / (1 + $tax / 100);

        return $this->build($nettValue, $grossValue, $tax);
    }

    /**
     * @param $nettValue float
     * @param $grossValue float
     * @param $tax float
     * @return PriceInterface
     */
    private function build($nettValue, $grossValue, $tax)
    {
        $price = new Price($this->calculator);
        $price->setNett($nettValue);
        $price->setGross($grossValue);
        $price->setTax($tax);
        $price->setCurrencySymbol($this->currencySymbol);

        return $this->decorate($price);
    }

    /**
     * @param PriceInterface $price
     * @return PriceInterface
     */
    public function decorate(PriceInterface $price)
    {
        $price = $price->getRaw(); //add flag

        foreach ($this->decorators as $decorator)
        {
            $clone = clone($decorator);
            $clone->setPrice($price);
            $clone->setCalculator($this->calculator);

            $price = $clone;
        }

        return $price;
    }
}