<?php

namespace App\Core\Finders;

use App\Core\Exceptions\ExecException;
use App\Core\Exceptions\PreloadException;
use App\Core\Interfaces\ResponseInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Single
 * @package App\Core\Finders
 */
class Single
{
    /**
     * @var ResponseInterface
     */
    protected $response;
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var int
     */
    protected $id;

    /**
     * @param ResponseInterface $response
     * @param Model $model
     * @param int $id
     * @return ResponseInterface
     */
    public function __invoke(ResponseInterface $response, Model $model, int $id): ResponseInterface
    {
        $this->model = $model;
        $this->response = $response;
        $this->id = $id;

        try {
            $this->preload();

            $this->exec();

            $this->response->setStatusCode(200);

            return $this->response;
        } catch (ExecException $exception) {
            $this->response->setStatusCode(500);
            return $this->response;
        } catch (PreloadException $exception) {
            $this->response->setStatusCode(404);
            return $this->response;
        }
    }

    /**
     *
     */
    protected function preload(): void
    {
        $this->model = $this->model->where('id', '=', $this->id);
        $this->model = $this->model->where('deleted', '=', 0);
    }

    /**
     *
     */
    protected function exec(): void
    {
        $this->response->setContent($this->model->first());
    }
}
