<?php

namespace BusinessDayBrazil;

use DateTime;

/**
 * Recupera dias úteis do Brasil
 * 
 * @category Date,DateTime
 * @package  BusinessDayBrazil
 * @author   Lucas Martins <lucasfsmartins@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/lucassena/business-day-brazil
 */
class BusinessDayBrazil
{
    /**
     * Retorna a data do próximo dia útil de acordo com a data atual ou especificada
     * no parâmetro $date.
     *
     * @param \DateTime|null $date Data alvo.
     * Observações: Se a data passada neste parâmetro for um dia útil ela é retornada, 
     * caso contrário é retornado a data do próximo dia útil referente a ela. 
     * Se $date for null, é retornado a data de amanhã ou do dia útil mais próximo.
     *
     * @return \DateTime
     */
    public static function nextDay(DateTime $date = null)
    {
        // se não for definido $date
        if ($date === null) {
            $date = new DateTime('now'); // define a data atual
            $date->modify('+1 weekday'); // e a modifica para o próximo dia da semana
        } else {
            // caso $date não for um dia útil
            if (!self::isBusinessDay($date)) {
                $date->modify('+1 weekday'); // a define para o próximo dia da semana
                $date = self::nextDay($date); // e re-executa a função
            }
        }

        return $date;
    }

    /**
     * Verifica se hoje ou a data especificada é dia útil.
     *
     * @param \DateTime $date Pode ser passado uma data específica para verificar se é um dia útil.
     *
     * @return boolean
     */
    public static function isBusinessDay(DateTime $date = null)
    {
        if ($date === null) {
            $date = new DateTime('now');
        }

        if (!\in_array($date->format('N'), array(6, 7))) {
            if (!\in_array($date->getTimestamp(), self::holidays($date->format('Y')))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Recupera feriados do Brasil
     *
     * @param integer|null $year Caso não seja especificado é retornado datas referente ao ano atual.
     *
     * @return array
     */
    public static function holidays(int $year = null)
    {
        $year = $year ?: \intval(date('Y'));
        
        /*
         * @see https://www.php.net/manual/pt_BR/function.easter-date.php
         */
        $easterDate = \easter_date($year);
        $easterDateDay = \date('j', $easterDate);
        $easterDateMonth = \date('n', $easterDate);
        $easterDateYear = \date('Y', $easterDate);
        
        $holidays = array(
            \mktime(null, null, null, 1, 1, $year), // Confraternização Universal - Lei nº 662, de 06/04/49
            \mktime(null, null, null, 4, 21, $year), // Tiradentes - Lei nº 662, de 06/04/49
            \mktime(null, null, null, 5, 1, $year), // Dia do Trabalhador - Lei nº 662, de 06/04/49
            \mktime(null, null, null, 9, 7, $year), // Dia da Independência - Lei nº 662, de 06/04/49
            \mktime(null, null, null, 10, 12, $year), // N. S. Aparecida - Lei nº 6802, de 30/06/80
            \mktime(null, null, null, 11, 2, $year), // Todos os santos - Lei nº 662, de 06/04/49
            \mktime(null, null, null, 11, 15, $year), // Proclamação da republica - Lei nº 662, de 06/04/49
            \mktime(null, null, null, 12, 25, $year), // Natal - Lei nº 662, de 06/04/49
            
            // Esses feriados têm a data dependendo do Dia de Páscoa
            \mktime(null, null, null, $easterDateMonth, $easterDateDay - 48, $easterDateYear), // Segunda-feira carnaval
            \mktime(null, null, null, $easterDateMonth, $easterDateDay - 47, $easterDateYear), // Terça-feira carnaval 
            \mktime(null, null, null, $easterDateMonth, $easterDateDay - 2, $easterDateYear), // Sexta-feira Santa
            \mktime(null, null, null, $easterDateMonth, $easterDateDay, $easterDateYear), // Páscoa
            \mktime(null, null, null, $easterDateMonth, $easterDateDay + 60, $easterDateYear),// Corpus Christi
        );
        
        return $holidays;
    }
}