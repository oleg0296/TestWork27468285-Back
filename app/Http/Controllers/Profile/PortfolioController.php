<?php

namespace App\Http\Controllers\Profile;

use App\Core\HttpFilters\HttpFilters;
use App\Core\Responses\HttpResponse;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Profile\Portfolio\CollectionResource;
use App\Http\Resources\Profile\Portfolio\ItemResource;
use App\Models\Profile\Portfolio;
use App\Services\Profile\Portfolio\Operations\Args;
use App\Services\Profile\Portfolio\Operations\Collection;
use App\Services\Profile\Portfolio\Operations\Destroy;
use App\Services\Profile\Portfolio\Operations\Single;
use App\Services\Profile\Portfolio\Operations\Create;
use App\Services\Profile\Portfolio\Operations\Update;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use App\Core\HttpFilters\Args as HttpArgs;

/**
 * Class PortfolioController
 * @package App\Http\Controllers\Profile
 */
class PortfolioController extends ApiController
{
    /**
     * Get portfolios list
     *
     * @SWG\Get(
     *     path="/portfolios",
     *     summary="Get list of portfolios",
     *     tags={"Web Portfolios"},
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/ProfilePortfolio")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Count items on page",
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Sort by (id/-id)",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         type="integer",
     *     ),
     * )
     *
     * @param Request $request
     * @param Collection $finder
     * @param Portfolio $model
     * @param HttpResponse $response
     * @return Response
     */
    public function index(
        Request $request,
        Collection $finder,
        Portfolio $model,
        HttpResponse $response
    ): Response
    {
       // $model->setPerPage(1);
        //$model = $model->where('id', '=', 1);
        //$model = $model->orWhere('id', '=', 2);
        //$model = $model->orderBy('id', 'asc');
        //$model = $model->paginate(10);
        //print_r($model->paginate(10));
        //die();
        //return (new CollectionResource($model));
        return $this->response($finder($response, $model, new HttpArgs($request->request)), CollectionResource::class);
    }

    /**
     * Create portfolio
     *
     * @SWG\Post(
     *     path="/portfolios",
     *     summary="Create portfolio",
     *     tags={"Web Portfolios"},
     *     description="Create portfolio",
     *     @SWG\Response(
     *         response=201,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ProfilePortfolio"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="formData",
     *         description="Name of portfolio",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="currency",
     *         in="formData",
     *         description="Currency of portfolio",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="hide",
     *         in="formData",
     *         description="Hide portfolio",
     *         type="integer",
     *     ),
     * )
     *
     * @param Request $request
     * @param Create $operation
     * @param Portfolio $model
     * @param HttpResponse $response
     * @return Response
     */
    public function store(
        Request $request,
        Create $operation,
        Portfolio $model,
        HttpResponse $response
    ): Response
    {
        return $this->response($operation($response, $model, new Args($request->request)), ItemResource::class);
    }

    /**
     * Get portfolio
     *
     * @SWG\Get(
     *     path="/portfolios/{id}",
     *     summary="Get portfolio by id",
     *     tags={"Web Portfolios"},
     *     description="Get portfolio by id",
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ProfilePortfolio"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Post is not found",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Portfolio id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     *
     * @param Request $request
     * @param int $id
     * @param Single $finder
     * @param Portfolio $model
     * @param HttpResponse $response
     * @return Response
     */
    public function show(Request $request, int $id, Portfolio $model, Single $finder, HttpResponse $response): Response
    {
        return $this->response($finder($response, $model, $id), ItemResource::class);
    }

    /**
     * Update portfolio
     *
     * @SWG\Put(
     *     path="/portfolios/{id}",
     *     summary="Update portfolio by id",
     *     tags={"Web Portfolios"},
     *     description="Update portfolio by id",
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ProfilePortfolio"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Post is not found",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Portfolio id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="formData",
     *         description="Name of portfolio",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="currency",
     *         in="formData",
     *         description="Currency of portfolio",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="hide",
     *         in="formData",
     *         description="Hide portfolio",
     *         type="integer",
     *     ),
     * )
     *
     * @param Request $request
     * @param int $id
     * @param Portfolio $model
     * @param Update $operation
     * @param HttpResponse $response
     * @return Response
     */
    public function update(Request $request, int $id, Portfolio $model, Update $operation, HttpResponse $response): Response
    {
        return $this->response($operation($response, $model, new Args($request->request, $id)), ItemResource::class);
    }

    /**
     * Delete portfolio
     *
     * @SWG\Delete(
     *     path="/portfolios/{id}",
     *     summary="Delete portfolio by id",
     *     tags={"Web Portfolios"},
     *     description="Delete portfolio by id",
     *     @SWG\Response(
     *         response=204,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Portfolio id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     *
     * @param $id
     * @param Portfolio $model
     * @param Destroy $operation
     * @param HttpResponse $response
     * @return Response
     */
    public function destroy($id, Portfolio $model, Destroy $operation, HttpResponse $response): Response
    {
        return $this->response($operation($response, $model, new Args(new ParameterBag(['deleted' => true]), $id)));
    }
}