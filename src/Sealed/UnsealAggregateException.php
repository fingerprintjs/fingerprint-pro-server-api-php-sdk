<?php

namespace Fingerprint\ServerAPI\Sealed;

use Exception;

/**
 * Thrown when unsealing fails with all provided decryption keys.
 *
 * Contains the individual {@see UnsealException} for each key that was tried.
 */
class UnsealAggregateException extends Exception
{
    /** @var Exception[] */
    private array $exceptions = [];

    /**
     * Creates a new UnsealAggregateException instance.
     */
    public function __construct()
    {
        parent::__construct('Failed to unseal with all decryption keys');
    }

    /**
     * Adds a decryption failure to this aggregate.
     */
    public function addException(Exception $exception): void
    {
        $this->exceptions[] = $exception;
    }

    /**
     * Returns all collected decryption exceptions.
     *
     * @return Exception[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
