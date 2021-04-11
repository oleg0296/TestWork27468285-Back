<?php

namespace App\Core\Fin\Currency;

use App\Core\Enum\Finance\Currency;

/**
 * Class RUB
 *
 * @package App\Fin\Currency
 */
class RUB implements CurrencyInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return Currency::RUB;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return Currency::NUM[Currency::RUB];
    }

    /**
     * @return int
     */
    public function getDivision(): int
    {
        return Currency::DIVISION[Currency::RUB];
    }
}