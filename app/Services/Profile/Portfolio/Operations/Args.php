<?php

namespace App\Services\Profile\Portfolio\Operations;

use App\Core\Operations\ArgsAbstract;
use Symfony\Component\HttpFoundation\ParameterBag;

class Args extends ArgsAbstract
{
    /** @var null|int  */
    private $id;

    /**
     * Args constructor.
     * @param ParameterBag $bag
     * @param null $id
     */
    public function __construct(ParameterBag $bag, $id = null)
    {
        parent::__construct($bag);
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getString('title');
    }

    /**
     * @return float|null
     */
    public function getSum(): ?float
    {
        return $this->getFloat('sum');
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->getString('currency');
    }

    /**
     * @return bool|null
     */
    public function isHide(): ?bool
    {
        return $this->getBool('hide');
    }

    /**
     * @return bool|null
     */
    public function isDeleted(): ?bool
    {
        return $this->getBool('deleted');
    }
}
