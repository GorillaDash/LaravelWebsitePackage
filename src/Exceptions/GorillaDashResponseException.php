<?php

namespace GorillaDash\LaravelWebsite\Exceptions;

/**
 * Class GorillaDashResponseException
 *
 * @package GorillaDash\LaravelWebsite\Exceptions
 */
class GorillaDashResponseException extends GorillaDashSDKException
{
    /**
     * @param $exception
     *
     * @return \GorillaDash\LaravelWebsite\Exceptions\GorillaDashResponseException
     */
    public static function create($exception): GorillaDashResponseException
    {
        $message = null;
        /** @var \Exception $exception */
        if ($exception) {
            $message = $exception->getMessage();
        }
        return new static($message);
    }
}
