<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\ResponseInterface;

/**
 * Class ApiController
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="profitoverview.loc:80",
 *   basePath="/api",
 *   @SWG\Info(
 *     title="Profit Overview API",
 *     version="v1"
 *   )
 * )
 */
class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param ResponseInterface $response
     * @param null|string $resource
     * @return mixed
     */
    protected function response(ResponseInterface $response, string $resource = null)
    {
        if ($resource === null || count($response->getErrors()) > 0) {
            return $response;
        }

        return (new $resource($response->getOriginalContent()))
            ->response()
            ->setStatusCode($response->getStatusCode())
            ->header('Content-Type', 'application/vnd.api+json')
            ->header('Accept', 'application/vnd.api+json');
    }
}