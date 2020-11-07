<?php


namespace App\Service\Valute\CBR;

use App\Service\Valute\ValuteModel;
use App\Service\Valute\ICalculator;

class Calculator implements ICalculator
{
    function calculate(float $value, ValuteModel $from, ValuteModel $to): float
    {
        return $this->currency($from, $to) * $value;
    }

    function currency(ValuteModel $from, ValuteModel $to): float
    {
        return ($from->value  / $from->nominal) / ($to->value / $to->nominal);
    }
}
