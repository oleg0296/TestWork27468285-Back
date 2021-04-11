<?php

namespace App\Core\Operations;

use App\Core\Exceptions\PreloadException;
use App\Core\Exceptions\SaveException;
use App\Core\Exceptions\ValidateException;
use App\Core\Interfaces\ResponseInterface;
use App\Core\Traits\AdminValidatorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class Store
 * @package App\Services\v1\Web\Portfolio\Operations
 */
abstract class Store
{
    use AdminValidatorTrait;

    /** @var Model */
    protected $model;

    /** @var ArgsAbstract */
    protected $args;

    /** @var ResponseInterface */
    protected $response;

    /**
     * @param ResponseInterface $response
     * @param Model $model
     * @param ArgsAbstract $args
     * @return ResponseInterface
     */
    public function __invoke(ResponseInterface $response, Model $model, ArgsAbstract $args): ResponseInterface
    {
        $this->response = $response;
        $this->args = $args;

        try {

            $this->preload($model);

            $this->validate();

            $this->exec();

            $this->save();

            $this->response->setStatusCode(201);
            $this->response->setContent($this->model);

            return $this->response;

        } catch (SaveException $exception) {
            $this->response->setStatusCode(500);
            $this->response->setContent($this->response->getErrors());
            return $this->response;
        } catch (ValidateException $exception) {
            $this->response->setStatusCode(400);
            $this->response->setContent($this->response->getErrors());
            return $this->response;
        } catch (PreloadException $exception) {
            $this->response->setStatusCode(404);
            $this->response->setContent($this->response->getErrors());
            return $this->response;
        }
    }

    /**
     * @param Model $model
     * @throws PreloadException
     */
    protected function preload(Model $model): void
    {
        if (null !== $this->args->getId()) {

            $this->model = $model::where('id', '=', $this->args->getId())->where('user_id', '=', Auth::id())->first();

            if (null === $this->model) {
                $this->response->addError(['title' => 'Model not found!']);
                throw new PreloadException('app.profile.preload');
            }

            return;
        }

        $this->model = $model;
    }

    protected function exec()
    {
    }

    /**
     * @throws SaveException
     */
    protected function save()
    {
        if (!$this->model->save()) {
            $this->response->addError(['title' => 'Undefined error! Data not saved!']);
            throw new SaveException('app.profile.save');
        }
    }

    /**
     * @throws ValidateException
     */
    protected function validate(): void
    {
        $validator = Validator::make($this->args->getAll(), $this->validateRules());

        if (!$validator->fails()) {
            return;
        }

        foreach ($validator->errors()->messages() as $attribute => $message) {
            $this->response->addError(['title' => $message, 'source' => ['parameter' => $attribute]]);
        }

        throw new ValidateException('app.profile.validate');
    }

    /**
     * @return array
     */
    protected abstract function validateRules();
}
