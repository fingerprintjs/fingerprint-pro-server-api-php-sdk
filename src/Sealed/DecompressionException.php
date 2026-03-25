<?php

namespace Fingerprint\ServerAPI\Sealed;

use Exception;

/**
 * Thrown when decompression of the decrypted sealed data fails.
 */
class DecompressionException extends Exception
{
    /**
     * Creates a new DecompressionException instance.
     */
    public function __construct()
    {
        parent::__construct('Decompression failed');
    }
}
