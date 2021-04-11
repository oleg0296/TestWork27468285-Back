<?php

namespace App\Services\Profile\Portfolio\Operations;

use App\Core\Finders\Single as BaseSingle;
use Illuminate\Support\Facades\Auth;

/**
 * Class Single
 * @package App\Services\Profile\Portfolio\Operations
 */
class Single extends BaseSingle
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