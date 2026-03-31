<?php

namespace Fingerprint\ServerSdk\Sealed;

class InvalidSealedDataHeaderException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid sealed data header');
    }
}
