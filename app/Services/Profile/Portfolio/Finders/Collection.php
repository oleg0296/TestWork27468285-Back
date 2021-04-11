<?php

namespace App\Services\Profile\Portfolio\Operations;

use App\Core\Finders\Collection as BaseCollection;
use Illuminate\Support\Facades\Auth;

/**
 * Class Collection
 * @package App\Services\Profile\Portfolio\Operations
 */
class Collection extends BaseCollection
{
    /**
     *
     */
    protected function preload(): void
    {
        parent::preload();

        $this->model = $this->model->where('user_id', '=', Auth::id());
    }
}