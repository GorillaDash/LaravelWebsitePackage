<?php

namespace GorillaDash\LaravelWebsite\Http\Controllers;

use GorillaDash\LaravelWebsite\GorillaDash;
use Illuminate\Routing\Controller;

/**
 * Class WebsiteController
 *
 * @package GorillaDash\LaravelWebsite\Http\Controllers
 */
class WebsiteController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function config()
    {
        return response()->json(GorillaDash::jsonVariables(), 201);
    }
}
