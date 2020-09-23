<?php

namespace GorillaDash\LaravelWebsite\Http\Controllers;

use Exception;
use GorillaDash\LaravelWebsite\Exceptions\GorillaDashEmptyResultException;
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
     * @throws \Throwable
     */
    public function query($query, Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $client = QueryFactory::create($query, $request->all());
            $data = $client->get();
            throw_if(count($data) === 0 || !is_array($data), GorillaDashEmptyResultException::class);

            return responder()->success($data)->respond(201);
        } catch (GorillaDashInvalidQueryException $ex) {
            return responder()->error($ex->getMessage())->respond(404);
        } catch (GorillaDashEmptyResultException $ex) {
            return responder()->error(404, 'no results')->respond(404);
        } catch (Exception $ex) {
            return responder()->error($ex->getMessage())->respond(500);
        }
    }

    /**
     * @param                          $query
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function mutation($query, Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            if (!$request->has('ip')) {
                $request->merge(['ip' => $request->getClientIp()]);
            }
            $client = QueryFactory::create($query, $request->all());
            $data = $client->get();

            return responder()->success($data)->respond(201);
        } catch (GorillaDashInvalidQueryException $ex) {
            return responder()->error($ex->getMessage())->respond(404);
        } catch (Exception $ex) {
            return responder()->error($ex->getMessage())->respond(500);
        }
    }
}
