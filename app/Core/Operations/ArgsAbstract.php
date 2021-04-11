<?php

namespace App\Core\Operations;

use App\Core\Traits\ParameterBagTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Interface ArgsInterface
 *
 * @package App\Core\Tasks
 */
abstract class ArgsAbstract
{
    use ParameterBagTrait;

    /**
     * ArgsAbstract constructor.
     *
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
}