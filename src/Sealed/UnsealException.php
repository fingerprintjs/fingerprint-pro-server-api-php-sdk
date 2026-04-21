<?php

namespace Fingerprint\ServerAPI\Sealed;

/**
 * @deprecated 6.11.0 Use \Fingerprint\ServerSdk\Sealed\UnsealException instead. This package will receive minor and security fixes until 2027/04/21 date, then be archived.
 */
class UnsealException extends \Exception
{
    public $decryptionKeyDescription;

    public function __construct($message, $cause, $decryptionKey)
    {
        parent::__construct($message, 0, $cause);
        $this->decryptionKeyDescription = $decryptionKey;
    }

    public function __toString()
    {
        return 'UnsealException{'.
            'decryptionKey='.$this->decryptionKeyDescription.
            ', message='.$this->getMessage().
            ', cause='.$this->getPrevious().
            '}';
    }
}
