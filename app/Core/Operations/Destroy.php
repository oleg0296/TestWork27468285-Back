<?php

namespace App\Core\Operations;

use App\Core\Exceptions\ExecException;
use App\Core\Exceptions\PreloadException;
use App\Core\Exceptions\SaveException;
use App\Core\Interfaces\ResponseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Destroy
 * @package App\Core\Operations
 */
abstract class Destroy
{
    /** @var Model */
    protected $model;

    /** @var ResponseInterface */
    protected $response;

    /** @var ArgsAbstract */
    protected $args;

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

            $this->exec();

            $this->save();

            $this->response->setStatusCode(204);

            return $this->response;

        } catch (ExecException $exception) {
            $this->response->setStatusCode(500);
            $this->response->setContent($this->response->getErrors());
            return $this->response;
        } catch (SaveException $exception) {
            $this->response->setStatusCode(500);
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
        $this->model = $model::where('id', '=', $this->args->getId())->where('user_id', '=', Auth::id())->first();

        if (null === $this->model) {
            $this->response->addError(['title' => 'Model not found!']);
            throw new PreloadException('app.profile.preload');
        }
    }

    /**
     *
     */
    protected function exec(): void
    {
        $this->model->deleted = 1;
    }

    /**
     * @throws SaveException
     */
    protected function save(): void
    {
        if (!$this->model->save()) {
            $this->response->addError(['title' => 'Undefined error! Data not saved!']);
            throw new SaveException('app.profile.save');
        }
    }
}
