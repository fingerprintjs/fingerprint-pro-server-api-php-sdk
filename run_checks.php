<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
if (file_exists('.env') || file_exists('.env.local')) {
    $dotenv->load();
    echo "Environment variables loaded from local env file.\n";
} else {
    echo "No local env file exists.";
}

$api_key = $_ENV['FP_PRIVATE_API_KEY'] ?? "Private API Key not defined";
$visitor_id = $_ENV['FP_VISITOR_ID'] ?? "Visitor ID not defined";
$request_id = $_ENV['FP_REQUEST_ID'] ?? "Request ID not defined";
$region_env = $_ENV['FP_REGION'] ?? "us";

$region = Configuration::REGION_GLOBAL;
if ($region_env === 'eu') {
    $region = Configuration::REGION_EUROPE;
} else if ($region_env === 'ap') {
    $region = Configuration::REGION_ASIA;
}

$config = Configuration::getDefaultConfiguration(
    $api_key,
    $region,
);

$client = new FingerprintApi(
    new Client(),
    $config
);

// Temporarily suppress a million deprecated ArrayAccess return type warnings for readability
// Our SDK generator does not yet support PHP's new attributes system
// https://github.com/swagger-api/swagger-codegen/issues/11820
error_reporting(error_reporting() & ~E_DEPRECATED);

try {
    $result = $client->getVisits($visitor_id);
    fwrite(STDOUT, sprintf("Got visits: %s \n", $result));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));
    exit(1);
}

try {
    $result = $client->getEvent($request_id);
    fwrite(STDOUT, sprintf("Got event: %s \n", $result));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));
    exit(1);
}

// Enable the deprecated ArrayAccess return type warning again if needed
error_reporting(error_reporting() | E_DEPRECATED);

fwrite(STDOUT, "Checks passed\n");
exit(0);
