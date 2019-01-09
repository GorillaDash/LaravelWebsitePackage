<?php

namespace GorillaDash\LaravelWebsite\Http\Controllers;

use Exception;
use GorillaDash\LaravelWebsite\Exceptions\GorillaDashInvalidQueryException;
use GorillaDash\LaravelWebsite\Queries\QueryFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class GorillaDashController
 *
 * @package GorillaDash\LaravelWebsite\Http\Controllers
 */
class GorillaDashController extends Controller
{
    /**
     * @param                          $query
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query($query, Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $client = QueryFactory::create($query, $request->all());
            return responder()->success($client->get())->respond(201);
        } catch (GorillaDashInvalidQueryException $ex) {
            return responder()->error($ex->getMessage())->respond(404);
        } catch (Exception $ex) {
            return responder()->error($ex->getMessage())->respond(500);
        }
    }
}
