<?php

namespace App\Core\Fin\Currency;

/**
 * Interface CurrencyInterface
 *
 * @package App\Fin\Currency
 */
interface CurrencyInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return int
     */
    public function getDivision(): int;
}