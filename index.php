<?php
require('./vendor/autoload.php');

use Price\Builder\Builder as PriceBuilder;
use Price\Decorator\ConvertCurrency as ConvertCurrencyDecorator;
use Price\Decorator\Round as RoundDecorator;

$rates = ['USD' => 1.000, 'PLN' => 3.3543];
$convertCurrencyDecorator = new ConvertCurrencyDecorator('USD', $rates);

$defaultRoundDecorator = new RoundDecorator(2);

$usdBuilder = new PriceBuilder();
$usdBuilder->addDecorator($defaultRoundDecorator);
$usdBuilder->addDecorator($convertCurrencyDecorator);
$usdBuilder->addDecorator($defaultRoundDecorator);
$usdBuilder->setCurrencySymbol('PLN');

$price = $usdBuilder->buildByNett(100.00, 10); //gross: 32.79 USD
$price->multiply(2); //gross: 65.58 USD


var_dump($price->getGross());
var_dump($price->getNett());
var_dump($price->getCurrencySymbol());




var_dump('-----------------------------------');

$plnBuilder = new PriceBuilder();
$plnBuilder->addDecorator($defaultRoundDecorator);
$plnBuilder->setCurrencySymbol('PLN');

$price = $plnBuilder->buildByNett(100.00, 10); //gross: 110.00 PLN
$price->multiply(2); //gross: 220.00 PLN
$price = $usdBuilder->decorate($price); //gross: 65.59 USD

var_dump($price->getGross());
var_dump($price->getNett());
var_dump($price->getCurrencySymbol());