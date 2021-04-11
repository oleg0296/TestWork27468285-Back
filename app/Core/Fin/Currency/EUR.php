<?php

namespace App\Core\Fin\Currency;

use App\Core\Enum\Finance\Currency;

/**
 * Class EUR
 *
 * @package App\Fin\Currency
 */
class EUR implements CurrencyInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return Currency::EUR;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return Currency::NUM[Currency::EUR];
    }

    /**
     * @return int
     */
    public function getDivision(): int
    {
        return Currency::DIVISION[Currency::EUR];
    }
}