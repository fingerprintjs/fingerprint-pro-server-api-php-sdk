<?php

namespace Fingerprint\ServerSdk\Sealed;

class UnsealException extends \Exception
{
    public string $decryptionKeyDescription;

    public function __construct($message, $cause, DecryptionKey $decryptionKey)
    {
        parent::__construct($message, 0, $cause);
        $key = $decryptionKey->getKey();
        $this->decryptionKeyDescription = substr($key, 0, 3).'***'.substr($key, -3);
    }

    public function __toString(): string
    {
        return 'UnsealException{'
            .'decryptionKey='.$this->decryptionKeyDescription
            .', message='.$this->getMessage()
            .', cause='.$this->getPrevious()
            .'}';
    }
}
