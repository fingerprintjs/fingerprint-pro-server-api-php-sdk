<?php

namespace Fingerprint\ServerAPI;

use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Model\ErrorCommon403Response;
use Fingerprint\ServerAPI\Model\ErrorCommon429Response;
use Fingerprint\ServerAPI\Model\ErrorEvent404Response;
use Fingerprint\ServerAPI\Model\ErrorUpdateEvent400Response;
use Fingerprint\ServerAPI\Model\ErrorUpdateEvent409Response;
use Fingerprint\ServerAPI\Model\ErrorVisitor400Response;
use Fingerprint\ServerAPI\Model\ErrorVisitor404Response;
use Fingerprint\ServerAPI\Model\ErrorVisits403;
use Fingerprint\ServerAPI\Model\EventUpdateRequest;
use Fingerprint\ServerAPI\Model\IdentificationError;
use Fingerprint\ServerAPI\Model\ProductError;
use Fingerprint\ServerAPI\Model\TooManyRequestsResponse;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class FingerprintApiTest extends TestCase
{
    /** @var FingerprintApi */
    protected $fingerprint_api;

    public const MOCK_REQUEST_ID = '1708102555327.NLOjmg';
    public const MOCK_REQUEST_ID_WITH_UNKNOWN = 'UNKNOWN_FIELD_REQUEST_ID';
    public const MOCK_REQUEST_ID_WITH_BROKEN = 'BROKEN_FIELD_REQUEST_ID';
    public const MOCK_EXTRA_FIELDS_REQUEST_ID = '0KSh65EnVoB85JBmloQK';
    public const MOCK_REQUEST_ALL_ERRORS = 'ALL_ERRORS';
    public const MOCK_REQUEST_EXTRA_FIELDS = 'EXTRA_FIELDS';
    public const MOCK_VISITOR_ID = 'AcxioeQKffpXF8iGQK3P';
    public const MOCK_VISITOR_REQUEST_ID = '1655373780901.HhjRFX';
    public const MOCK_VISITOR_ID_403_ERROR = 'VISITOR_ID_403_ERROR';
    public const MOCK_VISITOR_ID_429_ERROR = 'VISITOR_ID_429_ERROR';
    public const MOCK_EVENT_ID_403_ERROR = 'EVENT_ID_403_ERROR';
    public const MOCK_EVENT_ID_404_ERROR = 'EVENT_ID_404_ERROR';
    public const MOCK_VISITOR_ID_400_ERROR = 'VISITOR_ID_400_ERROR';
    public const MOCK_VISITOR_ID_404_ERROR = 'VISITOR_ID_404_ERROR';
    public const MOCK_EVENT_ID_409_ERROR = 'EVENT_ID_409_ERROR';
    public const MOCK_EVENT_ID = 'MOCK_EVENT_ID';
    public const MOCK_EVENT_ID_400_ERROR = 'EVENT_ID_400_ERROR';

    protected ClientInterface $client;
    protected MockHandler $mockHandler;

    protected function getVersion()
    {
        $config_file = file_get_contents(__DIR__ . '/../composer.json');
        $config = json_decode($config_file, true);

        return $config['version'];
    }

    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $this->client = new Client(['handler' => HandlerStack::create($this->mockHandler)]);
        $this->fingerprint_api = new FingerprintApi($this->client);
    }

    protected function getMockResponse(string $mockId, string $method = "GET", ?string $operationId = null): Response
    {
        $mock_name = "";
        $status = 200;
        $headers = [
            'Content-Type' => 'application/json',
        ];

        if ($method === "GET" || $method === "DELETE") {
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
                case self::MOCK_EVENT_ID_403_ERROR:
                    $mock_name = 'get_event_403_error.json';
                    $status = 403;
                    break;
                case self::MOCK_EVENT_ID_404_ERROR:
                    $mock_name = 'get_event_404_error.json';
                    $status = 404;
                    break;
                case self::MOCK_EVENT_ID_400_ERROR:
                    $mock_name = 'update_event_400_error.json';
                    $status = 400;
                    break;
                case self::MOCK_VISITOR_ID:
                    $mock_name = 'get_visits_200_limit_500.json';
                    break;
                case self::MOCK_VISITOR_REQUEST_ID:
                    $mock_name = "get_visits_200_limit_1.json";
                    break;
                case self::MOCK_VISITOR_ID_403_ERROR:
                    $mock_name = 'get_visits_403_error.json';
                    $status = 403;
                    break;
                case self::MOCK_VISITOR_ID_429_ERROR:
                    $mock_name = 'get_visits_429_too_many_requests_error.json';
                    $status = 429;
                    $headers['retry-after'] = 30;
                    break;
                case self::MOCK_VISITOR_ID_400_ERROR:
                    $mock_name = "400_error_incorrect_visitor_id.json";
                    $status = 400;
                    break;
                case self::MOCK_VISITOR_ID_404_ERROR:
                    $mock_name = "404_error_visitor_not_found.json";
                    $status = 404;
                    break;
            }
        }

        if ($method === "PUT") {
            switch ($mockId) {
                case self::MOCK_EVENT_ID:
                default:
                    $mock_name = "update_event.json";
                    break;
                case self::MOCK_EVENT_ID_409_ERROR:
                    $status = 409;
                    $mock_name = "update_event_409_error.json";
                    break;
                case self::MOCK_EVENT_ID_404_ERROR:
                    $status = 404;
                    $mock_name = "update_event_404_error.json";
                    break;
                case self::MOCK_EVENT_ID_403_ERROR:
                    $status = 403;
                    $mock_name = "update_event_403_error.json";
                    break;
                case self::MOCK_EVENT_ID_400_ERROR:
                    $status = 400;
                    $mock_name = "update_event_400_error.json";
                    break;
            }
        }

        $contents = file_get_contents(__DIR__ . "/mocks/$mock_name");
        if ($operationId) {
            $visits_mock_data = json_decode($contents);
            $visits_mock_data->visits = array_filter($visits_mock_data->visits, function ($item) use ($operationId) {
                return isset($item->requestId) && $item->requestId === $operationId;
            });
            $contents = json_encode($visits_mock_data);
        }

        return new Response($status, $headers, $contents);
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
        $this->assertEquals('notDetected', $botd_product->getData()->getBot()->getResult());
        $this->assertFalse($vpn_product->getData()->getMethods()->getPublicVpn());
        $this->assertEquals('94.142.239.124', $ip_info_product->getData()->getV4()->getAddress());
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
        $this->assertEquals(IdentificationError::CODE_FAILED, $identification_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $botd_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $emulator_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $incognito_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $tor_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $ip_blocklist_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $ip_info_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $proxy_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $root_apps_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $tampering_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $vpn_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $cloned_app_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $factory_reset_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $jailbroken_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $frida_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $privacy_settings_error->getCode());
        $this->assertEquals(ProductError::CODE_FAILED, $virtual_machine_error->getCode());

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
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID, "GET", self::MOCK_VISITOR_REQUEST_ID));

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
        $mockedResult = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . "/mocks/get_event_200.json"));
        $this->assertEquals($mockedResult, \GuzzleHttp\json_decode($response->getBody()->getContents()));
    }

    public function testGetVisitsRawResponse()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID));

        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID);
        $mockedResult = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . "/mocks/get_visits_200_limit_500.json"));
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
        $this->assertEquals("field", $responseBody->unknown);
        $this->assertEquals("field", $responseBody->products->unknown);
        $this->assertEquals("field", $responseBody->products->identification->unknown);
        $this->assertEquals("field", $responseBody->products->identification->data->unknown);
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
        $this->assertEquals("format", $responseBody->products->identification->data->linkedId->broken);
    }

    public function testDeleteVisitorData()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID, "DELETE"));

        list($result, $response) = $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetVisits403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_ERROR));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID_403_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorVisits403::class, get_class($e->getErrorDetails()));
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
            $this->assertEquals(TooManyRequestsResponse::class, get_class($e->getErrorDetails()));
            $this->assertEquals(30, $e->getRetryAfter());
            throw $e;
        }
    }

    public function testGetEvent403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_ERROR));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_403_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorCommon403Response::class, get_class($e->getErrorDetails()));
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
            $this->assertEquals(ErrorEvent404Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("request id is not found", $e->getErrorDetails()->getError()->getMessage());
            $this->assertEquals("RequestNotFound", $e->getErrorDetails()->getError()->getCode());
            throw $e;
        }
    }

    public function testDeleteVisitorData400Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_400_ERROR, "DELETE"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {

            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_400_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorVisitor400Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("invalid visitor id", $e->getErrorDetails()->getError()->getMessage());
            $this->assertEquals("RequestCannotBeParsed", $e->getErrorDetails()->getError()->getCode());
            throw $e;
        }
    }

    public function testDeleteVisitorData403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_403_ERROR, "DELETE"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorCommon403Response::class, get_class($e->getErrorDetails()));
            throw $e;
        }
    }

    public function testDeleteVisitorData404Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_404_ERROR, "DELETE"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_404_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorVisitor404Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("VisitorNotFound", $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorData429Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_VISITOR_ID_429_ERROR, "DELETE"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(429);

        try {
            $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_429_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorCommon429Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals(30, $e->getRetryAfter());
            throw $e;
        }
    }

    public function testUpdateEvent400Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_400_ERROR, "PUT"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_400_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorUpdateEvent400Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("RequestCannotBeParsed", $e->getErrorDetails()->getError()->getCode());
            throw $e;
        }
    }

    public function testUpdateEvent403Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_403_ERROR, "PUT"));


        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_403_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorCommon403Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("TokenRequired", $e->getErrorDetails()->getError()->getCode());
            throw $e;
        }
    }

    public function testUpdateEvent404Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_404_ERROR, "PUT"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_404_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorEvent404Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("RequestNotFound", $e->getErrorDetails()->getError()->getCode());
            throw $e;
        }
    }

    public function testUpdateEvent409Error()
    {
        $this->mockHandler->reset();
        $this->mockHandler->append($this->getMockResponse(self::MOCK_EVENT_ID_409_ERROR, "PUT"));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(409);

        try {
            $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_409_ERROR);
        } catch (ApiException $e) {
            $this->assertEquals(ErrorUpdateEvent409Response::class, get_class($e->getErrorDetails()));
            $this->assertEquals("StateNotReady", $e->getErrorDetails()->getError()->getCode());
            throw $e;
        }
    }
}
