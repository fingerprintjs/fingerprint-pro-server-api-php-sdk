<?php

namespace Fingerprint\ServerAPI\Sealed;

/**
 * @deprecated 6.11.0 Use \Fingerprint\ServerSdk\Sealed\DecryptionKey instead. This package will receive minor and security fixes until 2027/04/21 date, then be archived.
 */
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
