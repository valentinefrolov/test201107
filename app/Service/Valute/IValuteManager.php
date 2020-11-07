<?php


namespace App\Service\Valute;

interface IValuteManager
{
    function getData() : array;
    function getCalculator() : ICalculator;
    function getModel() : ValuteModel;
}
