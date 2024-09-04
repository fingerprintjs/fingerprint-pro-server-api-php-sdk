<?php

namespace Fingerprint\ServerAPI\Sealed;

class UnsealAggregateException extends \Exception
{
    /**
     * @var \Exception[]
     */
    private $exceptions;

    public function __construct()
    {
        parent::__construct('Failed to unseal with all decryption keys');
    }

    public function addException(\Exception $exception)
    {
        $this->exceptions[] = $exception;
    }

    public function getExceptions()
    {
        return $this->exceptions;
    }
}
