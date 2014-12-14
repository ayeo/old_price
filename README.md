Price
===========

Price handling. This library is under development. Do not use :)

### Basic Usage
```
use \Price\Builder\Builder as PriceBuilder;
use \Price\Decorator\Round as RoundDecorator;

$rawBuilder = new PriceBuilder();
$price = $rawBuilder->buildByNett(79.104, 10);
$price->multiply(2)->getNett(); //returns 158.208

//round existing Price
$roundedBuilder = new PriceBuilder();
$roundedBuilder->addDecorator(new RoundDecorator(2));
$roundedBuilder->decorate($price)->getNett(); //returns 158.21
```

### Use rounded values for calculations
```
$usdRoundedBuilder = new PriceBuilder();
$usdRoundedBuilder->setCurrencySymbol('USD');
$usdRoundedBuilder->addDecorator(new RoundDecorator(2));

$price = $usdRoundedBuilder->buildByNett(79.104, 10);
$price->multiply(2)->getNett(); //returns 158.20 USD
```

### Converting currency
You can convert currencies in two different ways. Example below shows converting each price seperatly. It may be useful if you store prices in PLN but want them to be dispayed as USD. Notice we use Round decorator twice
```
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
```
If you want do all calculations in source currency and then convert totals you can do:
```
$plnBuilder = new PriceBuilder();
$plnBuilder->addDecorator($defaultRoundDecorator);
$plnBuilder->setCurrencySymbol('PLN');

$price = $plnBuilder->buildByNett(100.00, 10); //gross: 110.00 PLN
$price->multiply(2); //gross: 220.00 PLN
$price = $usdBuilder->decorate($price); //gross: 65.59 USD
```
Notice that we get different result in these two examples 65.59 USD and 65.58 USD

### Custom configuration
To create builder with predefinied configuration you may want to use ConfigInterface
```
class MyDefaultConfiguration implements ConfigInterface
{
	public function getCalculator()
	{
		return new StandardCalculator();
	}

	public function getDecorators()
	{
		return [new Round(2)];
	}

	public function getCurrencySymbol()
	{
		return 'USD';
	}
}


$builder = new PriceBuilder(new MyDefaultConfiguration);
$builder->buildByGross(199.9891, 7); //gross: 199.99 USD
```

### Calculations
By default builder uses StandarCalculator. StandardCalculator performs operations by modifying given PriceInterface object. For example:
```
$priceA = $builder->buildByGross(100.00, 23);
$priceB = $builder->buildByGross(10.00, 23);

$priceA->add($priceB);
$priceA->getGross() //returns 110.00
```
If you need to change this behavior (for example return brand new Price object) you have to provide your own calculator (must implement CalculatorInterface or extends StandardCalculator).

### Available decorators
* NoNegative - returns 0.00 for prices below 0
* ConvertCurrency
* Round - allow to set prices precision

### TODO
* Add decorator for nice looknig prices like: 1.99, 9.99 etc