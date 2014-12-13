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

### Additional decorators
* NoNegative - returns 0.00 for prices below 0