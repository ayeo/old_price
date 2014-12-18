<?php
namespace Price\Builder\Config;

use Price\Calculator\StandardCalculator;

class StandardConfig implements ConfigInterface
{
    public function getCalculator()
    {
        return new StandardCalculator();
    }

    public function getDecorators()
    {
        return [];
    }

    public function getCurrencySymbol()
    {
        return null;
    }

}
