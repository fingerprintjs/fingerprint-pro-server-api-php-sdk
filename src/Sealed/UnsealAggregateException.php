<?php

namespace Fingerprint\ServerSdk\Sealed;

class UnsealAggregateException extends \Exception
{
    /**
     * @var UnsealException[]
     */
    private array $exceptions = [];

    public function __construct()
    {
        parent::__construct('Failed to unseal with all decryption keys');
    }

    public function addException(UnsealException $exception): void
    {
        $this->exceptions[] = $exception;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
