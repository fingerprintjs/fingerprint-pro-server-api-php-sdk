<?php

namespace Fingerprint\ServerAPI;

use Psr\Http\Message\ResponseInterface;

final class SerializationException extends \Exception
{
    protected readonly ResponseInterface $response;

    public function __construct(ResponseInterface $response, \Exception $prev)
    {
        parent::__construct("Response from the server couldn't be serialized", $prev->getCode(), $prev);
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
