<?php
require('./vendor/autoload.php');

$builder = new \Price\Builder\Builder();
$builder->setCurrencySymbol('PLN');
//$builder->addDecorator(new \Price\Decorator\Round(2));
$priceA = $builder->buildByNett(79.104, 23);

var_dump($priceA->multiply(2)->getNett());
$priceA = $builder->decorate($priceA, new \Price\Decorator\Round(2));
var_dump($priceA->getNett());


