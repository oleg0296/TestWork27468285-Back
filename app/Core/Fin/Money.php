<?php
declare(strict_types=1);

namespace App\Core\Fin;

use App\Core\Enum\Finance\Currency;
use App\Core\Fin\Currency\CurrencyInterface;

/**
 * Class Money
 *
 * @package App\Fin
 */
class Money
{
    /**
     * @var int
     */
    private $value;
    /**
     * @var CurrencyInterface
     */
    private $currency;

    /**
     * Money constructor.
     *
     * @param int               $value
     * @param CurrencyInterface $currency
     */
    public function __construct(int $value, CurrencyInterface $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return (string)($this->value / (10 ** $this->getDivision()));
    }

    /**
     * @return int
     */
    public function getValueTech(): int
    {
        return $this->value;
    }

    /**
     * @return CurrencyInterface
     */
    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getDivision(): int
    {
        return $this->currency->getDivision();
    }

    /**
     * @param int               $value
     * @param CurrencyInterface $currency
     *
     * @return static
     */
    public static function make($value, CurrencyInterface $currency): self
    {
        return new self($value * (10 ** $currency->getDivision()), $currency);
    }

    /**
     * @param int    $value
     * @param string $currency
     *
     * @return string
     */
    public static function getValueByTechValue(int $value, string $currency): string
    {
        return (string)($value / (10 ** Currency::DIVISION[$currency]));
    }

    /**
     * @param        $value
     * @param string $currency
     *
     * @return int
     */
    public static function getTechValueByValue($value, string $currency): int
    {
        return (int)($value * (10 ** Currency::DIVISION[$currency]));
    }
}