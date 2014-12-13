<?php
require('./vendor/autoload.php');

use \Price\Builder\Builder as PriceBuilder;
use \Price\Decorator\Round as RoundDecorator;

$usdRoundedBuilder = new PriceBuilder();
$usdRoundedBuilder->setCurrencySymbol('USD');
$usdRoundedBuilder->addDecorator(new RoundDecorator(2));

$price = $usdRoundedBuilder->buildByNett(79.104, 10);
$price->multiply(2)->getNett(); //returns 158.20
