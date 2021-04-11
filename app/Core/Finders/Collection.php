<?php

namespace App\Core\Finders;

use App\Core\Exceptions\ExecException;
use App\Core\Exceptions\PreloadException;
use App\Core\HttpFilters\Args;
use App\Core\HttpFilters\Filters\Filter;
use App\Core\HttpFilters\Filters\PerPage;
use App\Core\HttpFilters\Filters\Sort;
use App\Core\HttpFilters\HttpFilters;
use App\Core\Interfaces\ResponseInterface;
use Illuminate\Database\Eloquent\Model;
use App\Core\HttpFilters\Args as HttpArgs;

/**
 * Class Collection
 * @package App\Core\Finders
 */
class Collection
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var ResponseInterface
     */
    protected $response;
    /**
     * @var HttpArgs
     */
    protected $httpArgs;
    /**
     * @var Args
     */
    protected $httpFilters;

    /**
     * Collection constructor.
     * @param HttpFilters $httpFilters
     */
    public function __construct(HttpFilters $httpFilters)
    {
        $this->httpFilters = $httpFilters;
    }

    /**
     * @param ResponseInterface $response
     * @param Model $model
     * @param HttpArgs $httpArgs
     * @return ResponseInterface
     */
    public function __invoke(ResponseInterface $response, Model $model, HttpArgs $httpArgs): ResponseInterface
    {
        $this->model = $model;
        $this->response = $response;
        $this->httpArgs = $httpArgs;

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
        $this->model = $this->model->where('deleted', '=', 0);

        //$this->model = $this->httpFilters->load($this->httpArgs)->bind($this->model);

        print_r($this->model->paginate(1));
        die();
    }

    /**
     *
     */
    protected function exec(): void
    {
        $this->response->setContent($this->model->paginate(1));
    }
}
