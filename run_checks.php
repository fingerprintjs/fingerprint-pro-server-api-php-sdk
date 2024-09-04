<?php

require_once __DIR__.'/vendor/autoload.php';

$host = getenv('FP_API_HOST');
$api_key = getenv('FP_PRIVATE_API_KEY');

use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use Fingerprint\ServerAPI\Webhook\WebhookVerifier;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->safeLoad();

$api_key = $_ENV['FP_PRIVATE_API_KEY'] ?? getenv('FP_PRIVATE_API_KEY') ?? 'Private API Key not defined';
$visitor_id = $_ENV['FP_VISITOR_ID'] ?? getenv('FP_VISITOR_ID') ?? 'Visitor ID not defined';
$request_id = $_ENV['FP_REQUEST_ID'] ?? getenv('FP_REQUEST_ID') ?? 'Request ID not defined';
$region_env = $_ENV['FP_REGION'] ?? getenv('FP_REGION') ?? 'us';

$region = Configuration::REGION_GLOBAL;
if ('eu' === $region_env) {
    $region = Configuration::REGION_EUROPE;
} elseif ('ap' === $region_env) {
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
    list($result, $response) = $client->getVisits($visitor_id);
    if ($result->getVisitorId() !== $visitor_id) {
        throw new Exception('Argument visitorId is not equal to deserialized getVisitorId');
    }
    fwrite(STDOUT, sprintf("Got visits: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));

    exit(1);
}

try {
    /** @var \Fingerprint\ServerAPI\Model\EventResponse $result */
    list($result, $response) = $client->getEvent($request_id);
    if ($result->getProducts()->getIdentification()->getData()->getRequestId() !== $request_id) {
        throw new Exception('Argument requestId is not equal to deserialized getRequestId');
    }
    fwrite(STDOUT, sprintf("\n\nGot event: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));

    exit(1);
}

$eventPromise = $client->getEventAsync($request_id);
$eventPromise->then(function ($tuple) use ($request_id) {
    list($result, $response) = $tuple;
    if ($result->getProducts()->getIdentification()->getData()->getRequestId() !== $request_id) {
        throw new Exception('Argument requestId is not equal to deserialized getRequestId');
    }
    fwrite(STDOUT, sprintf("\n\nGot async event: %s \n", $response->getBody()->getContents()));
}, function ($exception) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getVisits: %s\n", $exception->getMessage()));

    exit(1);
})->wait();

$visitsPromise = $client->getVisitsAsync($visitor_id);
$visitsPromise->then(function ($tuple) use ($visitor_id) {
    list($result, $response) = $tuple;
    if ($result->getVisitorId() !== $visitor_id) {
        throw new Exception('Argument visitorId is not equal to deserialized getVisitorId');
    }
    fwrite(STDOUT, sprintf("\n\nGot async visits: %s \n", $response->getBody()->getContents()));
}, function ($exception) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getVisits: %s\n", $exception->getMessage()));

    exit(1);
})->wait();

$webhookSecret = 'secret';
$webhookData = 'data';
$webhookHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
$isValidWebhookSign = WebhookVerifier::IsValidWebhookSignature($webhookHeader, $webhookData, $webhookSecret);
if ($isValidWebhookSign) {
    fwrite(STDOUT, sprintf("\n\nVerified webhook signature\n"));
} else {
    fwrite(STDERR, sprintf("\n\nWebhook signature verification failed\n"));

    exit(1);
}

// Enable the deprecated ArrayAccess return type warning again if needed
error_reporting(error_reporting() | E_DEPRECATED);

fwrite(STDOUT, "\n\nChecks passed\n");

exit(0);
