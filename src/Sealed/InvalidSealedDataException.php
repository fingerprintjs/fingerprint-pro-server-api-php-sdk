<?php

namespace Fingerprint\ServerAPI\Sealed;

use InvalidArgumentException;

/**
 * Thrown when decrypted sealed data does not contain a valid event response.
 */
class InvalidSealedDataException extends InvalidArgumentException
{
    /**
     * Creates a new InvalidSealedDataException instance.
     */
    public function __construct()
    {
        parent::__construct('Invalid sealed data');
    }
}
