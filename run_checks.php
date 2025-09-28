<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use Fingerprint\ServerAPI\Model\EventsGetResponse;
use Fingerprint\ServerAPI\Model\EventsUpdateRequest;
use Fingerprint\ServerAPI\Model\VisitorsGetResponse;
use Fingerprint\ServerAPI\Model\SearchEventsResponse;
use Fingerprint\ServerAPI\Webhook\WebhookVerifier;
use GuzzleHttp\Client;

$host = getenv('FP_API_HOST');
$api_key = getenv('FP_PRIVATE_API_KEY');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

function env(string $key, ?string $default = null): ?string
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

$apiKey = env('FP_PRIVATE_API_KEY');
if (!$apiKey) {
    throw new Exception('FP_PRIVATE_API_KEY is not defined.');
}

$regionEnv = env('FP_REGION', 'us');
$visitorIdToDelete = env('FP_VISITOR_ID_TO_DELETE');
$requestIdToUpdate = env('FP_REQUEST_ID_TO_UPDATE');

$region = match(strtolower(trim($regionEnv))) {
    'eu' => Configuration::REGION_EUROPE,
    'ap' => Configuration::REGION_ASIA,
    default => Configuration::REGION_GLOBAL,
};

$config = Configuration::getDefaultConfiguration(
    $apiKey,
    $region,
);

$client = new FingerprintApi(
    new Client(),
    $config
);

$start = (new DateTime())->sub(new DateInterval('P3M'));
$end = new DateTime();

// FingerprintApi->searchEvents usage example
try {
    /** @var SearchEventsResponse $result */
    list($result, $response) = $client->searchEvents(10, start: $start->getTimestamp() * 1000, end: $end->getTimestamp() * 1000);
    if (!is_countable($result->getEvents()) || count($result->getEvents()) === 0) {
        throw new Exception('No events found');
    }
    $identificationData = $result->getEvents()[0]->getProducts()->getIdentification()->getData();
    $visitorId = $identificationData->getVisitorId();
    $requestId = $identificationData->getRequestId();
    fwrite(STDOUT, sprintf("\n\nGot events: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->searchEvents: %s\n", $e->getMessage()));

    exit(1);
}

// FingerprintApi->getVisits usage example
try {
    /** @var VisitorsGetResponse $result */
    list($result, $response) = $client->getVisits($visitorId);
    if ($result->getVisitorId() !== $visitorId) {
        throw new Exception('Argument visitorId is not equal to deserialized getVisitorId');
    }
    fwrite(STDOUT, sprintf("Got visits: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));

    exit(1);
}

// FingerprintApi->deleteVisitorData usage example
if ($visitorIdToDelete) {
    try {
        list($model, $response) = $client->deleteVisitorData($visitorIdToDelete);
        fwrite(STDOUT, sprintf("Visitor data deleted: %s \n", $response->getBody()->getContents()));
    } catch (Exception $e) {
        fwrite(STDERR, sprintf("Exception when calling FingerprintApi->deleteVisitorData: %s\n", $e->getMessage()));
        exit(1);
    }
}

// FingerprintApi->getEvent usage example
try {
    /** @var EventsGetResponse $result */
    list($result, $response) = $client->getEvent($requestId);
    if ($result->getProducts()->getIdentification()->getData()->getRequestId() !== $requestId) {
        throw new Exception('Argument requestId is not equal to deserialized getRequestId');
    }
    fwrite(STDOUT, sprintf("\n\nGot event: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getEvent: %s\n", $e->getMessage()));

    exit(1);
}

// FingerprintApi->updateEvent usage example
if ($requestIdToUpdate) {
    try {
        $body = new EventsUpdateRequest([
            'linked_id' => date('Y-m-d H:i:s'),
        ]);
        list($model, $response) = $client->updateEvent($body, $requestIdToUpdate);
        fwrite(STDOUT, sprintf("\n\nEvent updated: %s \n", $response->getBody()->getContents()));
    } catch (Exception $e) {
        fwrite(STDOUT, sprintf("\n\nException when calling FingerprintApi->updateEvent: %s\n", $e->getMessage()));
        exit(1);
    }
}

// Call API asynchronously examples
$eventPromise = $client->getEventAsync($requestId);
$eventPromise->then(function ($tuple) use ($requestId) {
    list($result, $response) = $tuple;
    if ($result->getProducts()->getIdentification()->getData()->getRequestId() !== $requestId) {
        throw new Exception('Argument requestId is not equal to deserialized getRequestId');
    }
    fwrite(STDOUT, sprintf("\n\nGot async event: %s \n", $response->getBody()->getContents()));
}, function ($exception) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getVisits: %s\n", $exception->getMessage()));

    exit(1);
})->wait();

$visitsPromise = $client->getVisitsAsync($visitorId);
$visitsPromise->then(function ($tuple) use ($visitorId) {
    list($result, $response) = $tuple;
    if ($result->getVisitorId() !== $visitorId) {
        throw new Exception('Argument visitorId is not equal to deserialized getVisitorId');
    }
    fwrite(STDOUT, sprintf("\n\nGot async visits: %s \n", $response->getBody()->getContents()));
}, function ($exception) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getEvent: %s\n", $exception->getMessage()));

    exit(1);
})->wait();

// Webhook verification example
$webhookSecret = 'secret';
$webhookData = 'data';
$webhookHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
$isValidWebhookSign = WebhookVerifier::IsValidWebhookSignature($webhookHeader, $webhookData, $webhookSecret);
if ($isValidWebhookSign) {
    fwrite(STDOUT, "\n\nVerified webhook signature\n");
} else {
    fwrite(STDERR, "\n\nWebhook signature verification failed\n");

    exit(1);
}

// Check that old events still match expected format
try {
    list($resultOld) = $client->searchEvents(1, start: $start->getTimestamp() * 1000, end: $end->getTimestamp() * 1000, reverse: true);
    if (!is_countable($resultOld->getEvents()) || count($resultOld->getEvents()) === 0) {
        throw new Exception('No old events found');
    }
    $identificationDataOld = $resultOld->getEvents()[0]->getProducts()->getIdentification()->getData();
    $visitorIdOld = $identificationDataOld->getVisitorId();
    $requestIdOld = $identificationDataOld->getRequestId();

    if ($requestId === $requestIdOld) {
        throw new Exception('Old events are identical to new');
    }

    list($result, $response) = $client->getEvent($requestIdOld);
    list($result, $response) = $client->getVisits($visitorIdOld);
    fwrite(STDOUT, "\n\nOld events are good\n");
}  catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when trying to read old data: %s\n", $e->getMessage()));
}

fwrite(STDOUT, "\n\nChecks passed\n");

exit(0);
