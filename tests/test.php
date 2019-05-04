<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use BusinessDayBrazil\BusinessDayBrazil;
echo BusinessDayBrazil::nextDay()->format('d/m/Y') . PHP_EOL;
echo BusinessDayBrazil::nextDay((new DateTime('2019-04-30'))->modify('+1 day'))->format('d/m/Y') . PHP_EOL;
echo BusinessDayBrazil::nextDay(new DateTime('2019-02-28'))->format('d/m/Y') . PHP_EOL;
echo BusinessDayBrazil::nextDay((new DateTime('2019-02-28'))->modify('+3 days'))->format('d/m/Y') . PHP_EOL;
$vencimento = BusinessDayBrazil::nextDay((new DateTime('2019-02-28'))->modify('+3 weekdays'));
echo $vencimento->format('d/m/Y') . PHP_EOL;
$diferenca = (new DateTime('2019-02-28'))->diff($vencimento);
echo $diferenca->format('%R%a days') . PHP_EOL;
echo (new DateTime())->diff((new DateTime())->modify('+3 weekdays'))->format('%R%a days') . PHP_EOL;

var_dump(BusinessDayBrazil::isBusinessDay());
var_dump(BusinessDayBrazil::holidays());