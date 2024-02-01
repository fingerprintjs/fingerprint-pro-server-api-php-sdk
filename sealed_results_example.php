<?php

use Fingerprint\ServerAPI\Sealed\DecryptionAlgorithm;
use Fingerprint\ServerAPI\Sealed\DecryptionKey;
use Fingerprint\ServerAPI\Sealed\Sealed;

require_once(__DIR__ . '/vendor/autoload.php');

$sealed_result = base64_decode($_ENV['BASE64_SEALED_RESULT'] ?? getenv('BASE64_SEALED_RESULT') ?? "");
$sealed_key = base64_decode($_ENV['BASE64_KEY'] ?? getenv('BASE64_KEY') ?? "");


// Temporarily suppress a million deprecated ArrayAccess return type warnings for readability
// Our SDK generator does not yet support PHP's new attributes system
// https://github.com/swagger-api/swagger-codegen/issues/11820
error_reporting(error_reporting() & ~E_DEPRECATED);

try {
    $data = Sealed::unsealEventResponse($sealed_result, [new DecryptionKey($sealed_key, DecryptionAlgorithm::AES_256_GCM)]);

    fwrite(STDOUT, sprintf("Unsealed event: %s \n", $data));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when unsealing event: %s\n", $e->getMessage()));
    exit(1);
}

// Enable the deprecated ArrayAccess return type warning again if needed
error_reporting(error_reporting() | E_DEPRECATED);

fwrite(STDOUT, "Checks passed\n");
exit(0);
