<?php

namespace Fingerprint\ServerAPI\Sealed;

/**
 * Holds a decryption key and its algorithm for unsealing sealed results.
 */
class DecryptionKey
{
    private readonly string $key;
    private readonly string $algorithm;

    /**
     * Creates a new DecryptionKey instance.
     *
     * @param string $key       raw binary decryption key
     * @param string $algorithm algorithm identifier ({@see DecryptionAlgorithm})
     */
    public function __construct(string $key, string $algorithm)
    {
        $this->key = $key;
        $this->algorithm = $algorithm;
    }

    /**
     * Returns the raw binary decryption key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Returns the algorithm identifier ({@see DecryptionAlgorithm}).
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }
}
