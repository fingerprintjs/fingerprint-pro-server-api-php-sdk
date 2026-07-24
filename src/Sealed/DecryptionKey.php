<?php

namespace Fingerprint\ServerSdk\Sealed;

readonly class DecryptionKey
{
    public function __construct(
        private string $key,
        private DecryptionAlgorithm $algorithm,
    ) {}

    public function getKey(): string
    {
        return $this->key;
    }

    public function getAlgorithm(): DecryptionAlgorithm
    {
        return $this->algorithm;
    }
}
