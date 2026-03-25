<?php

namespace Fingerprint\ServerAPI\Sealed;

use InvalidArgumentException;

/**
 * Thrown when the sealed payload does not start with the expected header bytes.
 */
class InvalidSealedDataHeaderException extends InvalidArgumentException
{
    /**
     * Creates a new InvalidSealedDataHeaderException instance.
     */
    public function __construct()
    {
        parent::__construct('Invalid sealed data header');
    }
}
