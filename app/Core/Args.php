<?php

namespace App\Core;

use App\Core\Traits\ParameterBagTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class Args
 * @package App\Core\HttpFilters
 */
class Args
{
    use ParameterBagTrait;

    /**
     * @var int
     */
    protected $page;
    /**
     * @var array
     */
    protected $filter = [];

    /**
     * Args constructor.
     * @param ParameterBag $bag
     */
    public function __construct(ParameterBag $bag)
    {
        $this->bag = $bag;
    }

    /**
     * @return string|int|null
     */
    public function getId()
    {
        return null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->bag->all();
    }

    /**
     * @return int|null
     */
    public function getPage(): int
    {
        return $this->getInt('page');
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        $filter = [];

        if (!$this->bag->get('filters')) {
            return $filter;
        }

        $num = 0;
        foreach ($this->bag->get('filters') as $attribute => $value) {

            if (strpos($value, ',') === false) {
                $filter[$num][] = self::buildFilterItem($attribute, $value);
                $num++;
                continue;
            }

            foreach (explode(',', $value) as $subValue) {
                $filter[$num][] = self::buildFilterItem($attribute, $subValue);
            }

            $num++;
        }

        return $filter;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getFilterOriginalByName(string $name)
    {
        $filters = $this->bag->get('filters');
        return (null !== $filters && array_key_exists($name, $filters)) ? $filters[$name] : null;
    }

    /**
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        return $this->getInt('per_page');
    }

    /**
     * @param $attribute
     * @param $value
     * @return array
     */
    protected static function buildFilterItem($attribute, $value): array
    {
        if (strpos($value, ':') === false) {
            return [$attribute, '=', $value];
        }

        $value = explode(':', $value);

        return [$attribute, $value[0], $value[1]];
    }
}