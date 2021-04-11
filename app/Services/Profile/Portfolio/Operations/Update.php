<?php

namespace App\Services\Profile\Portfolio\Operations;

use App\Core\Operations\Store;
use App\Models\Profile\Portfolio;

/**
 * Class Update
 * @package App\Services\Profile\Portfolio\Operations
 */
class Update extends Store
{
    /**
     * @var Portfolio
     */
    protected $model;
    /**
     * @var Args
     */
    protected $args;

    public function exec(): void
    {
        $this->model->hide = ($this->args->isHide()) ? 1 : 0;

        $this->stringTrim($this->args->getTitle(), 'title');
        $this->string($this->args->getCurrency(), 'currency');
    }

    /**
     * @return array
     */
    protected function validateRules(): array
    {
        return [];
    }
}
