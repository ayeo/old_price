Price
===========

Price handling. This library is under development. Do not use :)

### Usage
```
use \Price\Builder\Builder as PriceBuilder;
use \Price\Decorator\Round as RoundDecorator;

$builder = new PriceBuilder();
$priceA = $builder->buildByNett(79.104, 10);
$priceA->multiply(2)->getNett(); //returns 158.208

$builder->decorate($priceA, new RoundDecorator(2))->getNett(); //returns 158.21
```

### Use rounded values to calculations
```
$builder = new PriceBuilder();
$builder->setCurrencySymbol('USD');
$builder->addDecorator(new RoundDecorator(2));

$priceA = $builder->buildByNett(79.104, 10);
$priceA->multiply(2)->getNett(); //returns 158.20
```

### Converting currency
You can convert currencies in two different ways. Example below shows converting each price seperatly. It may be useful if you store prices in PLN but want them to be dispayed as USD. Notice we use Round decorator twice
```
use Price\Builder\Builder as PriceBuilder
use Price\Decorator\ConvertCurrency as ConvertCurrencyDecorator;
use Price\Decorator\Round as RoundDecorator;


$rates = ['USD' => 1.000, 'PLN' => 3.3543];
$convertCurrencyDecorator = new ConvertCurrencyDecorator('USD', $rates);

$defaultRoundDecorator = new RoundDecorator(2);

$builder = new PriceBuilder();
$builder->setCurrencySymbol('PLN');
$builder->addDecorator($defaultRoundDecorator);
$builder->addDecorator($convertCurrencyDecorator);
$builder->addDecorator($defaultRoundDecorator);

$price = $builder->buildByNett(100.00, 10); //gross: 32.79 USD
$price->multiply(2); //gross: 65.58 USD
```
If you want do all calculations in source currency and then convert totals you can do:
```
$builder = new PriceBuilder();
$builder->addDecorator($defaultRoundDecorator);
$builder->setCurrencySymbol('PLN');

$price = $builder->buildByNett(100.00, 10); //gross: 110.00 PLN
$price->multiply(2); //gross: 220.00 PLN

$price = $builder->decorate($price, $convertCurrencyDecorator); //gross: 65.5874549086 USD
$price = $builder->decorate($price, $defaultRoundDecorator); //gross: 65.59 USD
```
Notice that we get different result in these two examples 65.59 USD and 65.58 USD


### Available decorators
* NoNegative - returns 0.00 for prices below 0
* ConvertCurrency
* Round - allow to set prices precision

### TODO
* Add decorator for nice looknig prices like: 1.99, 9.99 etc