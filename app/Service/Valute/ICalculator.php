<?php


namespace App\Service\Valute;

interface ICalculator
{
    function calculate(float $value, ValuteModel $from, ValuteModel $to) : float;
    function currency(ValuteModel $from, ValuteModel $to) : float;
}
