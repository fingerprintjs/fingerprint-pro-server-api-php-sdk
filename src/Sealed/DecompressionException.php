<?php

namespace Fingerprint\ServerAPI\Sealed;

use Exception;

class DecompressionException extends Exception
{
    public function __construct()
    {
        parent::__construct("Decompression failed");
    }
}