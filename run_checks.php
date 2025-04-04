<?php

require_once __DIR__.'/vendor/autoload.php';

$host = getenv('FP_API_HOST');
$api_key = getenv('FP_PRIVATE_API_KEY');

use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use Fingerprint\ServerAPI\Model\EventsGetResponse;
use Fingerprint\ServerAPI\Model\EventsUpdateRequest;
use Fingerprint\ServerAPI\Model\VisitorsGetResponse;
use Fingerprint\ServerAPI\Model\SearchEventsResponse;
use Fingerprint\ServerAPI\Webhook\WebhookVerifier;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->safeLoad();

$api_key = $_ENV['FP_PRIVATE_API_KEY'] ?? getenv('FP_PRIVATE_API_KEY') ?? 'Private API Key not defined';
$visitor_id_to_delete = $_ENV['FP_VISITOR_ID_TO_DELETE'] ?? getenv('FP_VISITOR_ID_TO_DELETE') ?? false;
$request_id_to_update = $_ENV['FP_REQUEST_ID_TO_UPDATE'] ?? getenv('FP_REQUEST_ID_TO_UPDATE') ?? false;
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

// FingerprintApi->searchEvents usage example
try {
    // 3 month from now
    $start = (new DateTime())->sub(new DateInterval('P3M'));
    $end = new DateTime();

    /** @var SearchEventsResponse $result */
    list($result, $response) = $client->searchEvents(10, start: $start->getTimestamp() * 1000, end: $end->getTimestamp() * 1000);
    if (!is_countable($result->getEvents()) || count($result->getEvents()) === 0) {
        throw new Exception('No events found');
    }
    $identification_data = $result->getEvents()[0]->getProducts()->getIdentification()->getData();
    $visitor_id = $identification_data->getVisitorId();
    $request_id = $identification_data->getRequestId();
    fwrite(STDOUT, sprintf("\n\nGot events: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->searchEvents: %s\n", $e->getMessage()));

    exit(1);
}

// FingerprintApi->getVisits usage example
try {
    /** @var VisitorsGetResponse $result */
    list($result, $response) = $client->getVisits($visitor_id);
    if ($result->getVisitorId() !== $visitor_id) {
        throw new Exception('Argument visitorId is not equal to deserialized getVisitorId');
    }
    fwrite(STDOUT, sprintf("Got visits: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("Exception when calling FingerprintApi->getVisits: %s\n", $e->getMessage()));

    exit(1);
}

// FingerprintApi->deleteVisitorData usage example
if ($visitor_id_to_delete) {
    try {
        list($model, $response) = $client->deleteVisitorData($visitor_id_to_delete);
        fwrite(STDOUT, sprintf("Visitor data deleted: %s \n", $response->getBody()->getContents()));
    } catch (Exception $e) {
        fwrite(STDERR, sprintf("Exception when calling FingerprintApi->deleteVisitorData: %s\n", $e->getMessage()));
        exit(1);
    }
}

// FingerprintApi->getEvent usage example
try {
    /** @var EventsGetResponse $result */
    list($result, $response) = $client->getEvent($request_id);
    if ($result->getProducts()->getIdentification()->getData()->getRequestId() !== $request_id) {
        throw new Exception('Argument requestId is not equal to deserialized getRequestId');
    }
    fwrite(STDOUT, sprintf("\n\nGot event: %s \n", $response->getBody()->getContents()));
} catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getEvent: %s\n", $e->getMessage()));

    exit(1);
}

// FingerprintApi->updateEvent usage example
if ($request_id_to_update) {
    try {
        $body = new EventsUpdateRequest([
            'linked_id' => date('Y-m-d H:i:s'),
        ]);
        list($model, $response) = $client->updateEvent($body, $request_id_to_update);
        fwrite(STDOUT, sprintf("\n\nEvent updated: %s \n", $response->getBody()->getContents()));
    } catch (Exception $e) {
        fwrite("\n\nException when calling FingerprintApi->updateEvent: %s\n", $e->getMessage());
        exit(1);
    }
}

// Call API asynchronously examples
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
    fwrite(STDERR, sprintf("\n\nException when calling FingerprintApi->getEvent: %s\n", $exception->getMessage()));

    exit(1);
})->wait();

// Webhook verification example
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

// Check that old events still match expected format
try {
    list($result_old) = $client->searchEvents(1, start: $start->getTimestamp() * 1000, end: $end->getTimestamp() * 1000, reverse: true);
    if (!is_countable($result_old->getEvents()) || count($result_old->getEvents()) === 0) {
        throw new Exception('No old events found');
    }
    $identification_data_old = $result_old->getEvents()[0]->getProducts()->getIdentification()->getData();
    $visitor_id_old = $identification_data_old->getVisitorId();
    $request_id_old = $identification_data_old->getRequestId();

    if ($visitor_id === $visitor_id_old || $request_id === $request_id_old) {
        throw new Exception('Old events are identical to new');
    }

    list($result, $response) = $client->getEvent($request_id_old);
    list($result, $response) = $client->getVisits($visitor_id_old);
    fwrite(STDERR, sprintf("\n\nOld events are good\n"));
}  catch (Exception $e) {
    fwrite(STDERR, sprintf("\n\nException when trying to read old data: %s\n", $e->getMessage()));
}

// Enable the deprecated ArrayAccess return type warning again if needed
error_reporting(error_reporting() | E_DEPRECATED);

fwrite(STDOUT, "\n\nChecks passed\n");

exit(0);
