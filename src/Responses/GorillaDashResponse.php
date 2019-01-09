<?php

namespace GorillaDash\LaravelWebsite\Responses;

use Eastwest\Json\Json;
use Eastwest\Json\JsonException;
use GorillaDash\LaravelWebsite\Exceptions\GorillaDashResponseException;
use GorillaDash\LaravelWebsite\Requests\GorillaDashRequest;

/**
 * Class GorillaDashResponse
 *
 * @package GorillaDash\LaravelWebsite\Responses
 */
class GorillaDashResponse
{
    /**
     * @var \GorillaDash\LaravelWebsite\Requests\GorillaDashRequest
     */
    private $request;

    /**
     * @var string The raw body of response from GorillaDash
     */
    private $rawBody;

    /**
     * @var array The decode body of response from GorillaDash
     */
    private $body = [];

    /**
     * @var int The HTTP status code response from GorillaDash
     */
    private $statusCode;

    /**
     * @var array The headers returns from GorillaDash
     */
    private $headers;

    /**
     * @var \GorillaDash\LaravelWebsite\Exceptions\GorillaDashResponseException
     */
    private $thrownException;

    /**
     * GorillaDashResponse constructor.
     *
     * @param \GorillaDash\LaravelWebsite\Requests\GorillaDashRequest $request
     * @param                                                         $rawBody
     * @param int                                                     $statusCode
     * @param array                                                   $headers
     */
    public function __construct(GorillaDashRequest $request, $rawBody, int $statusCode, $headers = [])
    {
        $this->request = $request;
        $this->rawBody = $rawBody;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->decodeBody();
    }

    /**
     * Decode raw body to array
     */
    private function decodeBody(): void
    {
        try {
            $this->body = Json::decode($this->rawBody, true);
        } catch (JsonException $ex) {
            $this->makeException($ex);
        }
    }

    /**
     * Returns has errors
     * @return bool
     */
    public function isError(): bool
    {
        return (bool)$this->thrownException;
    }

    /**
     * Create the exception
     *
     * @param null $ex
     */
    public function makeException($ex = null): void
    {
        $this->thrownException = GorillaDashResponseException::create($ex);
    }

    /**
     *  Returns the exception.
     *
     * @return \GorillaDash\LaravelWebsite\Exceptions\GorillaDashResponseException|null
     */
    public function getThrownException(): ?GorillaDashResponseException
    {
        return $this->thrownException;
    }

    /**
     * Returns decode body
     *
     * @return array
     */
    public function getDecodedBody(): array
    {
        return $this->body;
    }
}
