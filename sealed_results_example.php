<?php

use Fingerprint\ServerSdk\Sealed\DecryptionAlgorithm;
use Fingerprint\ServerSdk\Sealed\DecryptionKey;
use Fingerprint\ServerSdk\Sealed\Sealed;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$sealed_result = base64_decode($_ENV['BASE64_SEALED_RESULT'] ?? getenv('BASE64_SEALED_RESULT') ?? '');
$sealed_key = base64_decode($_ENV['BASE64_KEY'] ?? getenv('BASE64_KEY') ?? '');

try {
    $data = Sealed::unsealEventResponse($sealed_result, [new DecryptionKey($sealed_key, DecryptionAlgorithm::AES_256_GCM)]);

    fwrite(STDOUT, sprintf("Unsealed event: %s \n", $data));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when unsealing event: %s\n", $e->getMessage()));

    exit(1);
}

fwrite(STDOUT, "Checks passed\n");

exit(0);
