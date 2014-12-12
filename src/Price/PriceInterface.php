<?php
namespace Price;

interface PriceInterface
{
	public function setCurrencySymbol($currencySymbol);

	public function setNett($nettValue);

	public function setGross($grossValue);

	public function setTax($tax);

	public function getGross();

	public function getNett();

	public function getTax();

	public function getCurrencySymbol();

	public function add(PriceInterface $price);

	public function cloneMe();
}