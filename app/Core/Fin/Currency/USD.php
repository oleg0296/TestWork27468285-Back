<?php

namespace App\Core\Fin\Currency;

use App\Core\Enum\Finance\Currency;

/**
 * Class USD
 *
 * @package App\Fin\Currency
 */
class USD implements CurrencyInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return Currency::USD;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return Currency::NUM[Currency::USD];
    }

    /**
     * @return int
     */
    public function getDivision(): int
    {
        return Currency::DIVISION[Currency::USD];
    }
}