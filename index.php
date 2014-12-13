<?php
require('./vendor/autoload.php');

$rates = ['USD' => 1.000, 'PLN' => 3.3543];
$convertCurrencyDecorator = new \Price\Decorator\ConvertCurrency('USD', $rates);

$defaultRoundDecorator = new \Price\Decorator\Round(2);

$builder = new \Price\Builder\Builder();
$builder->addDecorator($defaultRoundDecorator);
$builder->addDecorator($convertCurrencyDecorator);
$builder->addDecorator($defaultRoundDecorator);
$builder->setCurrencySymbol('PLN');

$price = $builder->buildByNett(100.00, 10); //gross: 32.79 USD
$price->multiply(2); //gross: 65.58 USD


var_dump($price->getGross());
var_dump($price->getNett());
var_dump($price->getCurrencySymbol());




var_dump('-----------------------------------');

$builder = new \Price\Builder\Builder();
$builder->addDecorator($defaultRoundDecorator);
$builder->setCurrencySymbol('PLN');

$price = $builder->buildByNett(100.00, 10); //gross: 110.00 PLN
$price->multiply(2); //gross: 220.00 PLN

$price = $builder->decorate($price, $convertCurrencyDecorator); //gross: 65.5874549086 USD

$price = $builder->decorate($price, $defaultRoundDecorator); //gross: 65.59 USD

var_dump($price->getGross());
var_dump($price->getNett());
var_dump($price->getCurrencySymbol());