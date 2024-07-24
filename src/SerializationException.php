<?php

namespace Fingerprint\ServerAPI;

use Exception;
use Psr\Http\Message\ResponseInterface;

final class SerializationException extends Exception
{
    protected readonly ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct("Response from the server couldn't be serialized");
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
