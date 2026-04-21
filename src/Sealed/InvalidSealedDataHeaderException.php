<?php

namespace Fingerprint\ServerAPI\Sealed;

/**
 * @deprecated 6.11.0 Use \Fingerprint\ServerSdk\Sealed\InvalidSealedDataHeaderException instead. This package will receive minor and security fixes until 2027/04/21 date, then be archived.
 */
class InvalidSealedDataHeaderException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid sealed data header');
    }
}
