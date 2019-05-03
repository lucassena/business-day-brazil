<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use BusinessDayBrazil\BusinessDayBrazil;
echo BusinessDayBrazil::nextDay()->format('Y-m-d');