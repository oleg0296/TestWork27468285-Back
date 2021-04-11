<?php

namespace App\Core\Traits;

use App\Core\Fin\Money;

/**
 * Trait AdminTrait
 *
 * @package App\Core\Traits
 */
trait AdminValidatorTrait
{
    /**
     * @param        $value
     * @param string $property
     */
    public function int($value, string $property): void
    {
        if (null === $value) {
            return;
        }

        $value = (int)$value;
        if ($value === (int)$this->get($property)) {
            return;
        }

        $this->set($property, $value);
    }

    /**
     * @param                   $value
     * @param string            $currency
     * @param string            $property
     */
    public function money($value, string $currency, string $property): void
    {
        if (null === $value) {
            return;
        }

        $money = Money::getTechValueByValue($value, $currency);
        if ($money === Money::getTechValueByValue($this->get($property), $currency)){
            return;
        }

        $this->set($property, $money);
    }

    /**
     * @param        $value
     * @param string $property
     */
    public function stringTrim($value, string $property): void
    {
        if (null === $value) {
            return;
        }

        $value = trim((string)$value);
        if ($value === $this->get($property)) {
            return;
        }

        $this->set($property, $value);
    }

    /**
     * @param        $value
     * @param string $property
     */
    public function string($value, string $property): void
    {
        if (null === $value) {
            return;
        }

        $value = (string)$value;
        if ($value === $this->get($property)) {
            return;
        }

        $this->set($property, $value);
    }

    /**
     * @param        $value
     * @param string $property
     */
    public function bool($value, string $property): void
    {
        if (null === $value) {
            return;
        }

        $value = (bool)$value;
        if ($value === $this->get($property)) {
            return;
        }

        $this->set($property, $value);
    }

    /**
     * @param        $value
     * @param string $property
     */
    public function sortArray($value, string $property): void
    {
        if (null === $value) {
            return;
        }

        $value = (array)$value;
        sort($value);
        $value = array_values($value);
        if ($value === (array)$this->get($property)) {
            return;
        }

        $this->set($property, $value);
    }

    /**
     * @param        $value
     * @param string $property
     */
    public function sortIntArray($value, string $property): void
    {
        /*if (null === $value) {
            return;
        }

        $value = (array)$value;

        $value = Arrays::intvalFilterArray($value);
        sort($value);
        $value = array_values($value);

        if (!$this->create && ($value === (array)$this->get($property))) {
            return;
        }

        $this->set($property, $value);*/
    }

    /**
     * @param        $value
     * @param string $property
     * @param string $format
     *
     * @return void
     */
    public function date($value, string $property, string $format = 'Y-m-d H:i:s'): void
    {
        /*if (null === $value) {
            return;
        }

        if ($value) {
            $value = date_create_from_format($format, $value);
            if (!$value) {
                return;
            }
        }

        if ($value === (array)$this->get($property)) {
            return;
        }

        $this->set($property, $value);*/
    }

    /**
     * @param $value
     * @param string $property
     */
    public function phone($value,  string $property): void
    {
        /*if (null === $value) {
            return;
        }

        if ($value) {
            $value = preg_replace('/\D/', '', $value);
            if (!$value) {
                return;
            }
        }

        if (!$this->create && ($value === (array)$this->get($property))) {
            return;
        }

        $this->set($property, $value);*/
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    private function get(string $property)
    {
        return $this->model->{$property};
    }

    /**
     * @param string $property
     * @param        $value
     *
     * @return mixed
     */
    protected function set(string $property, $value)
    {
        return $this->model->{$property} = $value;
    }

    /**
     * @param $str
     *
     * @return string
     */
    protected function snakeToCamel($str): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }

}
