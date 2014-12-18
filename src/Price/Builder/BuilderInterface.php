<?php
namespace Price\Builder;

use Price\Price\PriceInterface;
use Price\Decorator\AbstractDecorator;

interface BuilderInterface
{
    /**
     * @param $nettValue float
     * @param $tax float
     * @return PriceInterface
     */
    public function buildByNett($nettValue, $tax);

    /**
     * @param $grossValue float
     * @param $tax float
     * @return PriceInterface
     */
    public function buildByGross($grossValue, $tax);

    /**
     * @param AbstractDecorator $decorator
     */
    public function addDecorator(AbstractDecorator $decorator);

    /**
     * @param PriceInterface $price
     * @return PriceInterface
     */
    public function decorate(PriceInterface $price);
}