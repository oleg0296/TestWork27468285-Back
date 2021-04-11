<?php

namespace App\Core\Fin;

use App\Core\Enum\Finance\Currency;
use App\Core\Fin\Currency\CurrencyInterface;
use App\Core\Fin\Currency\EUR;
use App\Core\Fin\Currency\RUB;
use App\Core\Fin\Currency\USD;

/**
 * Class Enum
 *
 * @package App\Fin\Currency
 */
class Factory
{

    /**
     * @param string $currency
     *
     * @return CurrencyInterface
     */
    public static function make(string $currency): CurrencyInterface
    {
        switch ($currency) {
            case Currency::EUR:
                return new EUR();
            case Currency::RUB:
                return new RUB();
            case Currency::USD:
                return new USD();
            default:
                throw new \UnexpectedValueException("Unexpected currency `$currency`");
        }
    }

}