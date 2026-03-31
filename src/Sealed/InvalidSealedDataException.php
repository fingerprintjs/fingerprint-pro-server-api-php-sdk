<?php

namespace Fingerprint\ServerSdk\Sealed;

class InvalidSealedDataException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid sealed data');
    }
}
