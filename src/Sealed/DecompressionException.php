<?php

namespace Fingerprint\ServerAPI\Sealed;

class DecompressionException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Decompression failed');
    }
}
