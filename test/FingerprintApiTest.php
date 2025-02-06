<?php

namespace Fingerprint\ServerAPI;

use DateTime;
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Model\BotdBotResult;
use Fingerprint\ServerAPI\Model\ErrorCode;
use Fingerprint\ServerAPI\Model\ErrorPlainResponse;
use Fingerprint\ServerAPI\Model\ErrorResponse;
use Fingerprint\ServerAPI\Model\EventsUpdateRequest;
use Fingerprint\ServerAPI\Model\RelatedVisitorsResponse;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class FingerprintApiTest extends TestCase
{
    public const MOCK_REQUEST_ID = '1708102555327.NLOjmg';
    public const MOCK_REQUEST_ID_WITH_UNKNOWN = 'UNKNOWN_FIELD_REQUEST_ID';
    public const MOCK_REQUEST_ID_WITH_BROKEN = 'BROKEN_FIELD_REQUEST_ID';
    public const MOCK_EXTRA_FIELDS_REQUEST_ID = '0KSh65EnVoB85JBmloQK';
    public const MOCK_REQUEST_ALL_ERRORS = 'ALL_ERRORS';
    public const MOCK_REQUEST_EXTRA_FIELDS = 'EXTRA_FIELDS';
    public const MOCK_VISITOR_ID = 'AcxioeQKffpXF8iGQK3P';
    public const MOCK_VISITOR_REQUEST_ID = '1655373780901.HhjRFX';
    public const MOCK_VISITOR_ID_403_ERROR_FORBIDDEN = 'VISITOR_ID_403_ERROR';
    public const MOCK_VISITOR_ID_403_FEATURE_NOT_ENABLED = 'VISITOR_ID_403_FEATURE_NOT_ENABLED';
    public const MOCK_VISITOR_ID_403_TOKEN_NOT_FOUND = 'VISITOR_ID_403_TOKEN_NOT_FOUND';
    public const MOCK_VISITOR_ID_403_TOKEN_REQUIRED = 'VISITOR_ID_403_TOKEN_REQUIRED';
    public const MOCK_VISITOR_ID_403_WRONG_REGION = 'VISITOR_ID_403_WRONG_REGION';
    public const MOCK_VISITOR_ID_403_SUBSCRIPTION_NOT_ACTIVE = 'VISITOR_ID_403_SUBSCRIPTION_NOT_ACTIVE';
    public const MOCK_VISITOR_ID_429_ERROR = 'VISITOR_ID_429_ERROR';
    public const MOCK_ERROR_429_TOO_MANY_REQUESTS = 'VISITOR_ID_429_ERROR_DELETE';
    public const MOCK_EVENT_ID_403_TOKEN_REQUIRED = 'EVENT_ID_403_ERROR_TOKEN_REQUIRED';
    public const MOCK_EVENT_ID_403_TOKEN_NOT_FOUND = 'EVENT_ID_403_ERROR_TOKEN_NOT_FOUND';
    public const MOCK_EVENT_ID_403_WRONG_REGION = 'EVENT_ID_403_WRONG_REGION';
    public const MOCK_EVENT_ID_404_ERROR = 'EVENT_ID_404_ERROR';
    public const MOCK_VISITOR_ID_400_EMPTY_VISITOR_ID = 'VISITOR_ID_400_EMPTY_VISITOR_ID';
    public const MOCK_VISITOR_ID_400_INCORRECT_VISITOR_ID = 'VISITOR_ID_400_INCORRECT_VISITOR_ID';
    public const MOCK_VISITOR_ID_404_ERROR = 'VISITOR_ID_404_ERROR';
    public const MOCK_EVENT_ID_409_ERROR = 'EVENT_ID_409_ERROR';
    public const MOCK_EVENT_ID = 'MOCK_EVENT_ID';
    public const MOCK_EVENT_ID_400_ERROR = 'EVENT_ID_400_ERROR';
    public const MOCK_RELATED_VISITORS = 'MOCK_RELATED_VISITORS';

    protected FingerprintApi $fingerprint_api;

    protected ClientInterface $client;
    protected MockHandler $mockHandler;

    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $this->client = new Client(['handler' => HandlerStack::create($this->mockHandler)]);
        $this->fingerprint_api = new FingerprintApi($this->client);
    }

    public function testGetEvent()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ID));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID);
        $products = $event->getProducts();
        $identification_product = $products->getIdentification();
        $botd_product = $products->getBotd();
        $vpn_product = $products->getVpn();
        $ip_info_product = $products->getIpInfo();
        $cloned_app_product = $products->getClonedApp();
        $factory_reset_product = $products->getFactoryReset();
        $jailbroken_product = $products->getJailbroken();
        $frida_product = $products->getFrida();
        $privacy_settings_product = $products->getPrivacySettings();
        $virtual_machine_product = $products->getVirtualMachine();
        $request_id = $identification_product->getData()->getRequestId();
        $this->assertEquals(self::MOCK_REQUEST_ID, $request_id);
        $this->assertEquals(BotdBotResult::NOT_DETECTED, $botd_product->getData()->getBot()->getResult());
        $this->assertFalse($vpn_product->getData()->getMethods()->getPublicVpn());
        $this->assertEquals('94.142.239.124', $ip_info_product->getData()->getV4()->getAddress());
        $this->assertEquals($ip_info_product->getData()->getV4()->getGeolocation()->getSubdivisions()[0]->name, 'Hlavni mesto Praha');
        $this->assertFalse($cloned_app_product->getData()->getResult());
        $this->assertEquals(new \DateTime('1970-01-01T00:00:00Z'), $factory_reset_product->getData()->getTime());
        $this->assertFalse($jailbroken_product->getData()->getResult());
        $this->assertFalse($frida_product->getData()->getResult());
        $this->assertFalse($privacy_settings_product->getData()->getResult());
        $this->assertFalse($virtual_machine_product->getData()->getResult());

        $raw_device_attributes = $products->getRawDeviceAttributes()->getData();
        $this->assertEquals(127, $raw_device_attributes['architecture']->value);
        $this->assertEquals(35.73832903057337, $raw_device_attributes['audio']->value);
        $this->assertEquals('4dce9d6017c3e0c052a77252f29f2b1c', $raw_device_attributes['canvas']->value->Geometry);
        $this->assertEquals('p3', $raw_device_attributes['colorGamut']->value);
        $this->assertTrue($raw_device_attributes['cookiesEnabled']->value);

        $location_spuffing = $products->getLocationSpoofing()->getData();
        $this->assertFalse($location_spuffing->getResult());

        $high_activity = $products->getHighActivity()->getData();
        $this->assertFalse($high_activity->getResult());
    }

    public function testGetEventWithExtraFields()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_EXTRA_FIELDS));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_EXTRA_FIELDS);
        $products = $event->getProducts();
        $identification_product = $products->getIdentification();
        $request_id = $identification_product->getData()->getRequestId();
        $this->assertEquals(self::MOCK_EXTRA_FIELDS_REQUEST_ID, $request_id);
    }

    public function testGetEventWithAllErrors()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ALL_ERRORS));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ALL_ERRORS);
        $products = $event->getProducts();
        $identification_error = $products->getIdentification()->getError();
        $botd_error = $products->getBotd()->getError();
        $emulator_error = $products->getEmulator()->getError();
        $incognito_error = $products->getIncognito()->getError();
        $tor_error = $products->getTor()->getError();
        $ip_blocklist_error = $products->getIpBlocklist()->getError();
        $ip_info_error = $products->getIpInfo()->getError();
        $proxy_error = $products->getProxy()->getError();
        $root_apps_error = $products->getRootApps()->getError();
        $tampering_error = $products->getTampering()->getError();
        $vpn_error = $products->getVpn()->getError();
        $cloned_app_error = $products->getClonedApp()->getError();
        $factory_reset_error = $products->getFactoryReset()->getError();
        $jailbroken_error = $products->getJailbroken()->getError();
        $frida_error = $products->getFrida()->getError();
        $privacy_settings_error = $products->getPrivacySettings()->getError();
        $virtual_machine_error = $products->getVirtualMachine()->getError();
        $this->assertEquals(ErrorCode::FAILED, $identification_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $botd_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $emulator_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $incognito_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $tor_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $ip_blocklist_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $ip_info_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $proxy_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $root_apps_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $tampering_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $vpn_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $cloned_app_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $factory_reset_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $jailbroken_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $frida_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $privacy_settings_error->getCode());
        $this->assertEquals(ErrorCode::FAILED, $virtual_machine_error->getCode());

        $raw_device_attributes = $products->getRawDeviceAttributes()->getData();
        $this->assertEquals('Error', $raw_device_attributes['audio']->error->name);
        $this->assertEquals('Error', $raw_device_attributes['canvas']->error->name);
    }

    public function testGetVisits()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID));

        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID);
        $this->assertEquals($visits->getVisitorId(), self::MOCK_VISITOR_ID);
    }

    public function testGetVisitsByRequestId()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID, 'GET', self::MOCK_VISITOR_REQUEST_ID));

        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID, self::MOCK_VISITOR_REQUEST_ID);
        foreach ($visits->getVisits() as $visit) {
            $this->assertEquals($visit->getRequestId(), self::MOCK_VISITOR_REQUEST_ID);
        }
    }

    public function testGetVisitsWithLimit()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID));

        $limit = 100;
        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID, null, $limit);
        $count = count($visits->getVisits());
        $this->assertLessThanOrEqual($limit, $count);
    }

    public function testGetEventRawResponse()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ID));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID);
        $mockedResult = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . '/mocks/get_event_200.json'));
        $this->assertEquals($mockedResult, \GuzzleHttp\json_decode($response->getBody()->getContents()));
    }

    public function testGetEventNullableSeenAt()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ID));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID);
        $products = $event->getProducts();
        $seenAt = $products->getIdentification()->getData()->getLastSeenAt();
        $this->assertEquals(null, $seenAt->getGlobal());
    }

    public function testGetVisitsRawResponse()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID));

        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID);
        $mockedResult = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . '/mocks/get_visitors_200_limit_500.json'));
        $this->assertEquals($mockedResult, \GuzzleHttp\json_decode($response->getBody()->getContents()));
    }

    public function testGetEventParsedModelWithUnknownField()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ID_WITH_UNKNOWN));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID_WITH_UNKNOWN);
        $this->assertEquals(false, $event->getProducts()->getIncognito()->getData()->getResult());
    }

    public function testGetUnknownFieldFromEvent()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ID_WITH_UNKNOWN));

        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID_WITH_UNKNOWN);
        $responseBody = \GuzzleHttp\json_decode($response->getBody()->getContents());
        $this->assertEquals('field', $responseBody->unknown);
        $this->assertEquals('field', $responseBody->products->unknown);
        $this->assertEquals('field', $responseBody->products->identification->unknown);
        $this->assertEquals('field', $responseBody->products->identification->data->unknown);
    }

    public function testGetBrokenFormatEvent()
    {
        $event = null;
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_REQUEST_ID_WITH_BROKEN));

        try {
            list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID_WITH_BROKEN);
        } catch (SerializationException $exception) {
            $response = $exception->getResponse();
        }
        $responseBody = \GuzzleHttp\json_decode($response->getBody()->getContents());

        $this->assertNull($event);
        $this->assertNotNull($responseBody);
        $this->assertEquals('format', $responseBody->products->identification->data->linkedId->broken);
    }

    public function testDeleteVisitorData()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID, 'DELETE'));

        list($result, $response) = $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetVisits403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_ERROR_FORBIDDEN));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID_403_ERROR_FORBIDDEN);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorPlainResponse::class, get_class($e->getErrorDetails()));

            throw $e;
        }
    }

    public function testGetVisits429Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_429_ERROR));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(429);

        try {
            $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID_429_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorPlainResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(30, $e->getRetryAfter());

            throw $e;
        }
    }

    public function testGetEvent403TokenRequired()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_TOKEN_REQUIRED));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_403_TOKEN_REQUIRED);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOKEN_REQUIRED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetEvent403TokenNotFound()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_TOKEN_NOT_FOUND));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_403_TOKEN_NOT_FOUND);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOKEN_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetEvent403WrongRegion()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_WRONG_REGION));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_403_WRONG_REGION);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::WRONG_REGION, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetEvent404Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_404_ERROR));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_404_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals('request id is not found', $e->getErrorDetails()->getError()->getMessage());
            $this->assertEquals(ErrorCode::REQUEST_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData400IncorrectVisitorId()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_400_INCORRECT_VISITOR_ID, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_400_INCORRECT_VISITOR_ID);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals('invalid visitor id', $e->getErrorDetails()->getError()->getMessage());
            $this->assertEquals(ErrorCode::REQUEST_CANNOT_BE_PARSED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData400EmptyVisitorId()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_400_EMPTY_VISITOR_ID, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_400_EMPTY_VISITOR_ID);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals('visitor id is required', $e->getErrorDetails()->getError()->getMessage());
            $this->assertEquals(ErrorCode::REQUEST_CANNOT_BE_PARSED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData403FeatureNotEnabled()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_FEATURE_NOT_ENABLED, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_FEATURE_NOT_ENABLED);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::FEATURE_NOT_ENABLED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData403TokenNotFound()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_TOKEN_NOT_FOUND, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_TOKEN_NOT_FOUND);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOKEN_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData403TokenRequired()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_TOKEN_REQUIRED, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_TOKEN_REQUIRED);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOKEN_REQUIRED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData403WrongRegion()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_WRONG_REGION, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_WRONG_REGION);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::WRONG_REGION, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData403SubscriptionIsNotActive()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_SUBSCRIPTION_NOT_ACTIVE, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_SUBSCRIPTION_NOT_ACTIVE);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::SUBSCRIPTION_NOT_ACTIVE, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData404Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_404_ERROR, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_404_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::VISITOR_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData429Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_ERROR_429_TOO_MANY_REQUESTS, 'DELETE'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(429);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_ERROR_429_TOO_MANY_REQUESTS);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOO_MANY_REQUESTS, $e->getErrorDetails()->getError()->getCode());
            $this->assertEquals(30, $e->getRetryAfter());

            throw $e;
        }
    }

    public function testUpdateEvent()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append(new Response(200));
        $body = new EventsUpdateRequest([
            'linked_id' => 'test',
            'tag' => [
                'test' => 'true',
            ],
            'suspect' => false,
        ]);
        [, $res] = $this->fingerprint_api->updateEvent($body, self::MOCK_REQUEST_ID);

        $req = $this->mockHandler->getLastRequest();
        $this->assertEquals($req->getBody()->getContents(), json_encode([
            'linkedId' => 'test',
            'tag' => [
                'test' => 'true',
            ],
            'suspect' => false,
        ]));
        $this->assertEquals('PUT', $req->getMethod());

        $this->assertEquals(200, $res->getStatusCode());
    }

    public function testUpdateEvent400Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_400_ERROR, 'PUT'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->fingerprint_api->updateEvent(new EventsUpdateRequest([]), self::MOCK_EVENT_ID_400_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::REQUEST_CANNOT_BE_PARSED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testUpdateEvent403WrongRegion()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_WRONG_REGION, 'PUT'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->updateEvent(new EventsUpdateRequest([]), self::MOCK_EVENT_ID_403_WRONG_REGION);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::WRONG_REGION, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testUpdateEvent403TokenRequired()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_TOKEN_REQUIRED, 'PUT'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->updateEvent(new EventsUpdateRequest([]), self::MOCK_EVENT_ID_403_TOKEN_REQUIRED);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOKEN_REQUIRED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testUpdateEvent403TokenNotFound()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_TOKEN_NOT_FOUND, 'PUT'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->updateEvent(new EventsUpdateRequest([]), self::MOCK_EVENT_ID_403_TOKEN_NOT_FOUND);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOKEN_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testUpdateEvent404Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_404_ERROR, 'PUT'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->fingerprint_api->updateEvent(new EventsUpdateRequest([]), self::MOCK_EVENT_ID_404_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::REQUEST_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testUpdateEvent409Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_409_ERROR, 'PUT'));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(409);

        try {
            $this->fingerprint_api->updateEvent(new EventsUpdateRequest([]), self::MOCK_EVENT_ID_409_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::STATE_NOT_READY, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetRelatedVisitors()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_RELATED_VISITORS));

        list($relatedVisitors) = $this->fingerprint_api->getRelatedVisitors(self::MOCK_VISITOR_ID);

        $this->assertEquals($relatedVisitors->getRelatedVisitors()[0]->getVisitorId(), 'NtCUJGceWX9RpvSbhvOm');
        $this->assertEquals($relatedVisitors->getRelatedVisitors()[1]->getVisitorId(), '25ee02iZwGxeyT0jMNkZ');
    }

    public function testGetRelatedVisitors400Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_400_EMPTY_VISITOR_ID));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->fingerprint_api->getRelatedVisitors(self::MOCK_VISITOR_ID);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::REQUEST_CANNOT_BE_PARSED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetRelatedVisitors403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_FEATURE_NOT_ENABLED));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getRelatedVisitors(self::MOCK_VISITOR_ID);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::FEATURE_NOT_ENABLED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetRelatedVisitors404Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_404_ERROR));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->fingerprint_api->getRelatedVisitors(self::MOCK_VISITOR_ID);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::VISITOR_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testGetRelatedVisitors429Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_ERROR_429_TOO_MANY_REQUESTS));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(429);

        try {
            $this->fingerprint_api->getRelatedVisitors(self::MOCK_VISITOR_ID);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::TOO_MANY_REQUESTS, $e->getErrorDetails()->getError()->getCode());
            $this->assertEquals($e->getRetryAfter(), 30);

            throw $e;
        }
    }

    public function testSearchEventsWithOnlyLimit()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append(function (RequestInterface $request) {
            $queryArray = [];
            parse_str($request->getUri()->getQuery(), $queryArray);
            $this->assertCount(2, $queryArray);
            $this->assertEquals('10', $queryArray['limit']);

            return $this->returnMockResponse("get_event_search_200.json");
        });

        list($events) = $this->fingerprint_api->searchEvents(10);

        $this->assertCount(1, $events->getEvents());
        $this->assertEquals("Ibk1527CUFmcnjLwIs4A9", $events->getEvents()[0]->getProducts()->getIdentification()->getData()->getVisitorId());
    }

    public function testSearchEventsWithPartialParams()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append(function (RequestInterface $request) {
            $queryArray = [];
            parse_str($request->getUri()->getQuery(), $queryArray);
            $this->assertCount(5, $queryArray);
            $this->assertEquals('10', $queryArray['limit']);
            $this->assertEquals('true', $queryArray['reverse']);
            $this->assertEquals('linked_id', $queryArray['linked_id']);

            return $this->returnMockResponse("get_event_search_200.json");
        });

        list($events) = $this->fingerprint_api->searchEvents(10, self::MOCK_VISITOR_ID, null, null, "linked_id", null, null, true);

        $this->assertCount(1, $events->getEvents());
        $this->assertEquals("Ibk1527CUFmcnjLwIs4A9", $events->getEvents()[0]->getProducts()->getIdentification()->getData()->getVisitorId());
    }

    public function testSearchEventsWithAllParams()
    {
        $start = new DateTime('2020-01-01 00:00:00');
        $end = new DateTime('2020-01-02 00:00:00');

        $this->mockHandler->reset();
        $this->mockHandler->append(function (RequestInterface $request) use ($end, $start) {
            $queryArray = [];
            parse_str($request->getUri()->getQuery(), $queryArray);
            $this->assertCount(10, $queryArray);
            $this->assertEquals('10', $queryArray['limit']);
            $this->assertEquals('true', $queryArray['reverse']);
            $this->assertEquals('linked_id', $queryArray['linked_id']);
            $this->assertEquals($start->getTimestamp(), $queryArray['start']);
            $this->assertEquals($end->getTimestamp(), $queryArray['end']);
            $this->assertEquals('true', $queryArray['suspect']);
            $this->assertEquals('good', $queryArray['bot']);

            return $this->returnMockResponse('get_event_search_200.json');
        });

        list($events) = $this->fingerprint_api->searchEvents(10, self::MOCK_VISITOR_ID, 'good', '127.0.0.1/16', 'linked_id', $start->getTimestamp(), $end->getTimestamp(), true, true);

        $this->assertCount(1, $events->getEvents());
        $this->assertEquals('Ibk1527CUFmcnjLwIs4A9', $events->getEvents()[0]->getProducts()->getIdentification()->getData()->getVisitorId());
    }

    public function testSearchEvents400Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->returnMockResponse('errors/400_bot_type_invalid.json', 400));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->fingerprint_api->searchEvents(10, self::MOCK_VISITOR_ID, 'invalid',);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::REQUEST_CANNOT_BE_PARSED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testSearchEvents403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->returnMockResponse('errors/403_subscription_not_active.json', 403));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->searchEvents(10);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(ErrorCode::SUBSCRIPTION_NOT_ACTIVE, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    protected function getVersion()
    {
        $config_file = file_get_contents(__DIR__ . '/../composer.json');
        $config = json_decode($config_file, true);

        return $config['version'];
    }

    protected function getMockResponse(string $mockId, string $method = 'GET', ?string $operationId = null): Response
    {
        $mock_name = '';
        $status = 200;
        $headers = [
            'Content-Type' => 'application/json',
        ];

        if ('GET' === $method || 'DELETE' === $method) {
            switch ($mockId) {
                case self::MOCK_REQUEST_ID:
                    $mock_name = 'get_event_200.json';

                    break;

                case self::MOCK_REQUEST_ALL_ERRORS:
                    $mock_name = 'get_event_200_all_errors.json';

                    break;

                case self::MOCK_REQUEST_EXTRA_FIELDS:
                    $mock_name = 'get_event_200_extra_fields.json';

                    break;

                case self::MOCK_REQUEST_ID_WITH_UNKNOWN:
                    $mock_name = 'get_event_200_with_unknown_field.json';

                    break;

                case self::MOCK_REQUEST_ID_WITH_BROKEN:
                    $mock_name = 'get_event_200_with_broken_format.json';

                    break;

                case self::MOCK_EVENT_ID_403_TOKEN_REQUIRED:
                    $mock_name = 'errors/403_token_required.json';
                    $status = 403;

                    break;

                case self::MOCK_EVENT_ID_403_TOKEN_NOT_FOUND:
                    $mock_name = 'errors/403_token_not_found.json';
                    $status = 403;

                    break;

                case self::MOCK_EVENT_ID_403_WRONG_REGION:
                    $mock_name = 'errors/403_wrong_region.json';
                    $status = 403;

                    break;

                case self::MOCK_EVENT_ID_404_ERROR:
                    $mock_name = 'errors/404_request_not_found.json';
                    $status = 404;

                    break;

                case self::MOCK_EVENT_ID_400_ERROR:
                    $mock_name = 'errors/400_request_body_invalid.json';
                    $status = 400;

                    break;

                case self::MOCK_VISITOR_ID:
                    $mock_name = 'get_visitors_200_limit_500.json';

                    break;

                case self::MOCK_VISITOR_REQUEST_ID:
                    $mock_name = 'get_visitors_200_limit_1.json';

                    break;

                case self::MOCK_VISITOR_ID_403_ERROR_FORBIDDEN:
                    $mock_name = 'get_visitors_403_forbidden.json';
                    $status = 403;

                    break;

                case self::MOCK_VISITOR_ID_403_FEATURE_NOT_ENABLED:
                    $mock_name = 'errors/403_feature_not_enabled.json';
                    $status = 403;

                    break;

                case self::MOCK_VISITOR_ID_403_TOKEN_NOT_FOUND:
                    $mock_name = 'errors/403_token_not_found.json';
                    $status = 403;

                    break;

                case self::MOCK_VISITOR_ID_403_TOKEN_REQUIRED:
                    $mock_name = 'errors/403_token_required.json';
                    $status = 403;

                    break;

                case self::MOCK_VISITOR_ID_403_WRONG_REGION:
                    $mock_name = 'errors/403_wrong_region.json';
                    $status = 403;

                    break;

                case self::MOCK_VISITOR_ID_403_SUBSCRIPTION_NOT_ACTIVE:
                    $mock_name = 'errors/403_subscription_not_active.json';
                    $status = 403;

                    break;

                case self::MOCK_VISITOR_ID_429_ERROR:
                    $mock_name = 'get_visitors_429_too_many_requests.json';
                    $status = 429;
                    $headers['retry-after'] = 30;

                    break;

                case self::MOCK_ERROR_429_TOO_MANY_REQUESTS:
                    $mock_name = 'errors/429_too_many_requests.json';
                    $status = 429;
                    $headers['retry-after'] = 30;

                    break;

                case self::MOCK_VISITOR_ID_400_INCORRECT_VISITOR_ID:
                    $mock_name = 'errors/400_visitor_id_invalid.json';
                    $status = 400;

                    break;

                case self::MOCK_VISITOR_ID_400_EMPTY_VISITOR_ID:
                    $mock_name = 'errors/400_visitor_id_required.json';
                    $status = 400;

                    break;

                case self::MOCK_VISITOR_ID_404_ERROR:
                    $mock_name = 'errors/404_visitor_not_found.json';
                    $status = 404;

                    break;

                case self::MOCK_RELATED_VISITORS:
                    $mock_name = 'related-visitors/get_related_visitors_200.json';

                    break;
            }
        }

        if ('PUT' === $method) {
            switch ($mockId) {
                case self::MOCK_EVENT_ID:
                default:
                    $mock_name = 'update_event.json';

                    break;

                case self::MOCK_EVENT_ID_409_ERROR:
                    $status = 409;
                    $mock_name = 'errors/409_state_not_ready.json';

                    break;

                case self::MOCK_EVENT_ID_404_ERROR:
                    $status = 404;
                    $mock_name = 'errors/404_request_not_found.json';

                    break;

                case self::MOCK_EVENT_ID_403_TOKEN_REQUIRED:
                    $status = 403;
                    $mock_name = 'errors/403_token_required.json';

                    break;

                case self::MOCK_EVENT_ID_403_TOKEN_NOT_FOUND:
                    $status = 403;
                    $mock_name = 'errors/403_token_not_found.json';

                    break;

                case self::MOCK_EVENT_ID_403_WRONG_REGION:
                    $status = 403;
                    $mock_name = 'errors/403_wrong_region.json';

                    break;

                case self::MOCK_EVENT_ID_400_ERROR:
                    $status = 400;
                    $mock_name = 'errors/400_request_body_invalid.json';

                    break;
            }
        }

        $contents = file_get_contents(__DIR__ . "/mocks/{$mock_name}");
        if ($operationId) {
            $visits_mock_data = json_decode($contents);
            $visits_mock_data->visits = array_filter($visits_mock_data->visits, function ($item) use ($operationId) {
                return isset($item->requestId) && $item->requestId === $operationId;
            });
            $contents = json_encode($visits_mock_data);
        }

        return new Response($status, $headers, $contents);
    }

    protected function returnMockResponse(string $path, $status = 200, array $headers = []): Response
    {
        $contents = file_get_contents(__DIR__ . "/mocks/{$path}");

        return new Response($status, $headers, $contents);
    }
}
