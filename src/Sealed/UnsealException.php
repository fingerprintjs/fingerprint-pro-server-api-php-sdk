<?php

namespace Fingerprint\ServerAPI\Sealed;


use Exception;

class UnsealException extends Exception
{
    public $decryptionKeyDescription;

    public function __construct($message, $cause, $decryptionKey)
    {
        parent::__construct($message, 0, $cause);
        $this->decryptionKeyDescription = $decryptionKey;
    }

    public function __toString()
    {
        return "UnsealException{" .
            "decryptionKey=" . $this->decryptionKeyDescription .
            ", message=" . $this->getMessage() .
            ", cause=" . $this->getPrevious() .
            '}';
    }
}