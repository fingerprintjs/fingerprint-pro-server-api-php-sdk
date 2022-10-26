<?php
require_once(__DIR__ . '/vendor/autoload.php');
$host = getenv('FP_API_HOST');
$api_key = getenv('FP_PRIVATE_API_KEY');

$config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()
    ->setApiKey('api_key', $api_key)
    ->setHost($host);

$apiInstance = new Fingerprint\ServerAPI\Api\FingerprintApi(
    new GuzzleHttp\Client(),
    $config
);

$visitor_id = getenv('FP_VISITOR_ID');
$request_id = getenv('FP_REQUEST_ID');

try {
    $result = $apiInstance->getVisits($visitor_id);
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));
    exit(1);
}

try {
    $result = $apiInstance->getEvent($request_id);
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));
    exit(1);
}

fwrite(STDOUT, "Checks passed\n");
exit(0);
