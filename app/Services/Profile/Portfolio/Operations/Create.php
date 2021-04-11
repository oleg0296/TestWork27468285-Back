<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 22.02.20
 * Time: 21:32
 */

namespace App\Services\Profile\Portfolio\Operations;

use App\Core\Operations\Store as BaseStore;
use App\Models\Profile\Portfolio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Store
 * @package App\Services\v1\Web\Portfolio\Operations
 */
class Create extends BaseStore
{
    /**
     * @var Portfolio
     */
    protected $model;
    /**
     * @var Args
     */
    protected $args;

    /**
     *
     */
    protected function exec(): void
    {
        $this->model->user_id = Auth::id();
        $this->model->deleted = 0;
        $this->model->sum = 0;
        $this->model->hide = ($this->args->isHide()) ? 1 : 0;

        $this->stringTrim($this->args->getTitle(), 'title');
        $this->string($this->args->getCurrency(), 'currency');
    }

    /**
     * @return array
     */
    protected function validateRules(): array
    {
        return [
            'title' => 'required|string',
            'currency' => 'required|string',
            'hide' => 'boolean'
        ];
    }
}
