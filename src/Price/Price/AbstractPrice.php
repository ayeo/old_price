<?php
namespace Price\Price;

abstract class AbstractPrice implements PriceInterface
{
    /**
     * @var float
     */
    private $nettValue;

    /**
     * @var float
     */
    private $grossValue;

    /**
     * @var float
     */
    private $tax;

    /**
     * @var null|string
     */
    private $currencySymbol = null;

    /**
     * @param $currencySymbol string|null
     */
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;
    }

    /**
     * @return string|null
     */
    public function getCurrencySymbol()
    {
        return $this->currencySymbol;
    }

    /**
     * @param $nettValue float
     */
    public function setNett($nettValue)
    {
        $this->nettValue = (float)$nettValue;
    }

    /**
     * @param $grossValue float
     */
    public function setGross($grossValue)
    {
        $this->grossValue = (float)$grossValue;
    }

    /**
     * @param $tax float
     */
    public function setTax($tax)
    {
        $this->tax = (float)$tax;
    }

    /**
     * @return float
     */
    public function getGross()
    {
        return $this->grossValue;
    }

    /**
     * @return float
     */
    public function getNett()
    {
        return $this->nettValue;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return PriceInterface
     */
    final public function cloneMe()
    {
        return clone($this);
    }

    /**
     * @return Price
     */
    final public function getRaw()
    {
        return $this;
    }


    /**
     * @param PriceInterface $price
     * @return PriceInterface
     */
    abstract public function add(PriceInterface $price);

    /**
     * @param PriceInterface $price
     * @return PriceInterface
     */
    abstract public function subtract(PriceInterface $price);

    /**
     * @param $times
     * @return PriceInterface
     */
    abstract public function multiply($times);
}