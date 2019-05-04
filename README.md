# Business day Brazil
Recupera informações sobre dias úteis do Brasil.

## Examples

```php
<?php
use BusinessDayBrazil\BusinessDayBrazil;

// Supondo que hoje é dia 03/05/2019
echo BusinessDayBrazil::nextDay()->format('d/m/Y'); // 06/05/2019

// Supondo que hoje é dia 30/04/2019 (véspera do feriado Dia do Trabalhador)
echo BusinessDayBrazil::nextDay()->format('d/m/Y'); // 02/05/2019

// Supondo que hoje é dia 28/02/2019, quase véspera de Carnaval, e você quer o vencimento do boleto para daqui 3 dias úteis
$vencimento = BusinessDayBrazil::nextDay((new \DateTime())->modify('+3 weekdays'))->format('d/m/Y'); // 06/03/2019
$diferenca = $vencimento->diff(new DateTime(), true);
echo $diferenca->format('%r%a') . PHP_EOL; // 6
```
