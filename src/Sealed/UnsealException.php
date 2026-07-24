<?php

namespace Fingerprint\ServerSdk\Sealed;

class UnsealException extends \Exception
{
    public readonly string $decryptionKeyDescription;

    public function __construct(string $message, \Throwable $cause, DecryptionKey $decryptionKey)
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
