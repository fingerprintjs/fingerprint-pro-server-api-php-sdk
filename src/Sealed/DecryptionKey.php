<?php

namespace Fingerprint\ServerSdk\Sealed;

class DecryptionKey
{
    private string $key;
    private DecryptionAlgorithm $algorithm;

    public function __construct(string $key, DecryptionAlgorithm $algorithm)
    {
        $this->key = $key;
        $this->algorithm = $algorithm;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getAlgorithm(): DecryptionAlgorithm
    {
        return $this->algorithm;
    }
}
