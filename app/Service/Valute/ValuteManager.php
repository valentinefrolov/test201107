<?php


namespace App\Service\Valute;

use Psy\Exception\RuntimeException;

abstract class ValuteManager implements IValuteManager
{

    public static function getManager(string $type) : IValuteManager {
        switch(strtolower($type)) {
            case 'cbr' :
                return new CBR\ValuteManager();
            default:
                throw new RuntimeException("Type $type not supported");
        }
    }

}
