<?php

namespace Fingerprint\ServerAPI\Sealed;

class DecryptionKey
{
    private $key;
    private $algorithm;

    public function __construct($key, $algorithm)
    {
        $this->key = $key;
        $this->algorithm = $algorithm;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getAlgorithm()
    {
        return $this->algorithm;
    }
}