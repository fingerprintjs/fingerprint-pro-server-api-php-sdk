<?php

namespace Fingerprint\ServerAPI\Sealed;

class InvalidSealedDataHeaderException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid sealed data header');
    }
}
