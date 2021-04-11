<?php
/*
 * This file is part of the package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\Core\Traits;


use Symfony\Component\HttpFoundation\ParameterBag;

trait ParameterBagTrait
{
    /**
     * @var ParameterBag
     */
    protected $bag;

    /**
     * @param string $property
     *
     * @return bool
     */
    protected function has(string $property): bool
    {
        return $this->bag->has($property);
    }

    /**
     * @param             $property
     *
     * @param string|null $default
     *
     * @return string|null
     */
    protected function getString($property, ?string $default = null): ?string
    {
        return $this->bag->has($property) ? trim($this->bag->get($property)) : $default;
    }

    /**
     * @param             $property
     *
     * @param string|null $default
     *
     * @return string|null
     */
    protected function getStringRaw($property, ?string $default = null): ?string
    {
        return $this->bag->has($property) ? $this->bag->get($property) : $default;
    }

    /**
     * @param          $property
     *
     * @param int|null $default
     *
     * @return int|null
     */
    protected function getInt($property, ?int $default = null): ?int
    {
        return $this->bag->has($property) ? $this->bag->getInt($property) : $default;
    }

    /**
     * @param           $property
     *
     * @param bool|null $default
     *
     * @return bool|null
     */
    protected function getBool($property, ?bool $default = null): ?bool
    {
        return $this->bag->has($property) ? $this->bag->getBoolean($property) : $default;
    }

    /**
     * @param $property
     *
     * @return float|null
     */
    protected function getFloat($property): ?float
    {
        if ($this->bag->has($property)) {
            return (float)str_replace([',', ' '], ['.', ''], trim($this->bag->get($property)));
        }

        return null;

    }

    /**
     * @param $property
     *
     * @return string[]|null
     */
    protected function getArrayString($property): ?array
    {
        if ($this->bag->has($property)) {
            $items = [];
            foreach ($this->bag->get($property) as $item) {
                if ($item = trim($item)) {
                    $items[] = $item;
                }
            }

            return $items;
        }

        return null;
    }

    /**
     * @param $property
     *
     * @return int[]|null
     */
    protected function getArrayInt($property): ?array
    {
        if ($this->bag->has($property)) {
            $items = [];
            foreach ($this->bag->get($property) as $item) {
                if ($item = (int)$item) {
                    $items[] = $item;
                }
            }

            return $items;
        }

        return null;
    }
}