<?php

namespace Fingerprint\ServerAPI\Sealed;

use Exception;

/**
 * Thrown when a single decryption key fails to unseal the data.
 *
 * Carries the {@see DecryptionKey} that was used, so callers can
 * identify which key failed.
 */
class UnsealException extends Exception
{
    private readonly DecryptionKey $decryptionKey;

    /**
     * Creates a new UnsealException instance.
     *
     * @param string        $message       error description
     * @param Exception     $cause         underlying decryption exception
     * @param DecryptionKey $decryptionKey the key that failed
     */
    public function __construct(string $message, Exception $cause, DecryptionKey $decryptionKey)
    {
        parent::__construct($message, 0, $cause);
        $this->decryptionKey = $decryptionKey;
    }

    /**
     * Returns the decryption key that was used when this failure occurred.
     */
    public function getDecryptionKey(): DecryptionKey
    {
        return $this->decryptionKey;
    }

    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'UnsealException{'.
            'decryptionKey='.$this->decryptionKey->getAlgorithm().
            ', message='.$this->getMessage().
            ', cause='.$this->getPrevious().
            '}';
    }
}
