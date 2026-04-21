<?php

namespace Fingerprint\ServerAPI\Sealed;

/**
 * @deprecated 6.11.0 Use \Fingerprint\ServerSdk\Sealed\UnsealAggregateException instead. This package will receive minor and security fixes until 2027/04/21 date, then be archived.
 */
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
