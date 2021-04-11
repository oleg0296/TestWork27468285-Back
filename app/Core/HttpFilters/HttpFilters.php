<?php

namespace App\Core\HttpFilters;

use App\Core\HttpFilters\Filters\Filter;
use App\Core\HttpFilters\Filters\PerPage;
use App\Core\HttpFilters\Filters\Sort;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HttpFilters
 * @package App\Core\HttpFilters
 */
class HttpFilters
{
    /**
     * @var PerPage
     */
    protected $perPage;
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Sort
     */
    protected $sort;
    /**
     * @var Args
     */
    protected $args;

    /**
     * HttpFilters constructor.
     * @param PerPage $perPage
     * @param Filter $filter
     * @param Sort $sort
     */
    public function __construct(PerPage $perPage, Filter $filter, Sort $sort)
    {
        $this->perPage = $perPage;
        $this->filter = $filter;
        $this->sort = $sort;
    }

    /**
     * @param Args $args
     * @return $this
     */
    public function load(Args $args): self
    {
        $this->args = $args;

        return $this;
    }

    /**
     * @param Model $model
     * @return Collection
     */
    public function bind(Model $model): Collection
    {
        $model = $this->perPage->load($this->args)->bind($model);
        $model = $this->filter->load($this->args)->bind($model);
        $model = $this->sort->load($this->args)->bind($model);

        return $model;
    }
}
