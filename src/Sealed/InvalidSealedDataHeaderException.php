<?php

namespace Fingerprint\ServerAPI\Sealed;

use InvalidArgumentException;

class InvalidSealedDataHeaderException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Invalid sealed data header");
    }
}
