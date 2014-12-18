<?php
namespace Price\Builder\Config;

interface ConfigInterface
{
    public function getCalculator();

    public function getDecorators();

    public function getCurrencySymbol();
}
