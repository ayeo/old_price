<?php
require('./vendor/autoload.php');

$builder = new \Price\Builder\Builder();
$builder->setCurrencySymbol('PLN');
$builder->addDecorator(new \Price\Decorator\Round(2));
$priceA = $builder->buildByNett(79.99, 23);
$priceB = $builder->buildByNett(79.99, 23);

var_dump($priceA == $priceB);

//var_dump($priceA->getGross());
//var_dump($priceA->getNett());
//var_dump($priceA->getTax());
////var_dump($priceA);
//
//var_dump($priceB->getGross());
//var_dump($priceB->getNett());
//var_dump($priceB->getTax());

var_dump($priceA->add($priceA)->getNett());

$decorator = new \Price\Decorator\Round(0);
$priceA = $builder->decorate($priceA, $decorator);

var_dump($priceA->getNett());