<?php

namespace Fingerprint\ServerSdk\Sealed;

enum DecryptionAlgorithm: string
{
    case AES_256_GCM = 'aes-256-gcm';
}
