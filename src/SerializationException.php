<?php

namespace Fingerprint\ServerAPI;

use Psr\Http\Message\ResponseInterface;
use Throwable;

final class SerializationException extends \Exception
{
    protected ?ResponseInterface $response;

    public function __construct(?ResponseInterface $response = null, ?Throwable $prev = null)
    {
        parent::__construct("Response from the server couldn't be serialized", $prev ? $prev->getCode() : 0, $prev);
        $this->response = $response;
    }

    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
