<?php

namespace Fingerprint\ServerAPI;

use Exception;
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Model\EventResponse;
use Fingerprint\ServerAPI\Model\EventUpdateRequest;
use Fingerprint\ServerAPI\Model\IdentificationError;
use Fingerprint\ServerAPI\Model\ProductError;
use Fingerprint\ServerAPI\Model\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

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

    protected function getMethod($method_name)
    {
        $class = new ReflectionClass(FingerprintApi::class);
        $get_event_request_method = $class->getMethod($method_name);
        $get_event_request_method->setAccessible(true);
        return $get_event_request_method;
    }

    protected function getVersion()
    {
        $config_file = file_get_contents(__DIR__ . '/../composer.json');
        $config = json_decode($config_file, true);

        return $config['version'];
    }

    public function setUp(): void
    {
        $config = new Configuration();
        $config->setHost(getenv('FP_API_HOST'));
        $config->setApiKey('api_key', getenv('FP_PRIVATE_API_KEY'));
        $this->fingerprint_api = $this->getMockBuilder(FingerprintApi::class)
            ->getMock();

        $this->fingerprint_api->method('getEvent')->will($this->returnCallback([$this, 'getEventWithHttpInfoMock']));
        $this->fingerprint_api->method('getVisits')->will($this->returnCallback([$this, 'getVisitsWithHttpInfoMock']));
        $this->fingerprint_api->method('deleteVisitorData')->will($this->returnCallback([$this, 'deleteVisitorDataWithHttpInfoMock']));
        $this->fingerprint_api->method('updateEvent')->will($this->returnCallback([$this, 'updateEventWithHttpInfoMock']));
    }

    /**
     * @throws \ReflectionException
     * @throws SerializationException
     */
    public function getEventWithHttpInfoMock($request_id): array
    {
        $event_request_method = $this->getMethod('getEventRequest');
        /** @var \GuzzleHttp\Psr7\Request $event_request */
        $event_request = $event_request_method->invokeArgs($this->fingerprint_api, [self::MOCK_REQUEST_ID]);
        $query = $event_request->getUri()->getQuery();
        $this->assertStringContainsString("ii=" . urlencode("fingerprint-pro-server-php-sdk/" . $this->getVersion()), $query);
        $mock_name = "";
        $status = 200;
        switch ($request_id) {
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
        }

        $file = file_get_contents(__DIR__ . "/mocks/$mock_name");
        $response = new \GuzzleHttp\Psr7\Response($status, [], $file);

        if ($status !== 200) {
            throw new ApiException("Error Processing Request", $status);
        }

        try {
            $serialized = ObjectSerializer::deserialize($response, EventResponse::class);
        } catch (Exception $exception) {
            throw new SerializationException($response, $exception);
        }

        return [$serialized, $response];
    }

    /**
     * @throws SerializationException
     */
    public function getVisitsWithHttpInfoMock($visitor_id, $request_id = null, $linked_id = null, $limit = null, $before = null): array
    {
        $mockFileMap = [
            self::MOCK_VISITOR_ID => ['file' => 'get_visits_200_limit_500.json', 'status' => 200],
            self::MOCK_VISITOR_ID_403_ERROR => ['file' => 'get_visits_403_error.json', 'status' => 403],
            self::MOCK_VISITOR_ID_429_ERROR => ['file' => 'get_visits_429_too_many_requests_error.json', 'status' => 429],
        ];

        $mock = $mockFileMap[$visitor_id];
        $file = file_get_contents(__DIR__ . "/mocks/" . $mock['file']);
        $visits_mock_data = \GuzzleHttp\json_decode($file);

        if ($request_id) {
            $visits_mock_data->visits = array_filter($visits_mock_data->visits, function ($item) use ($request_id) {
                return isset($item->requestId) && $item->requestId === $request_id;
            });
        }

        if ($limit && is_numeric($limit)) {
            $visits_mock_data->visits = array_slice($visits_mock_data->visits, 0, $limit);
        }

        $response = new \GuzzleHttp\Psr7\Response($mock['status'], [], json_encode($visits_mock_data));

        if ($mock['status'] !== 200) {
            throw new ApiException("Error Processing Request", $mock['status']);
        }

        $serialized = ObjectSerializer::deserialize($response, Response::class);
        return [$serialized, $response];
    }

    public function deleteVisitorDataWithHttpInfoMock($visitor_id): array
    {
        $mockFileMap = [
            self::MOCK_VISITOR_ID_400_ERROR => ['file' => '400_error_empty_visitor_id.json', 'status' => 400],
            self::MOCK_VISITOR_ID_403_ERROR => ['file' => '403_error_feature_not_enabled.json', 'status' => 403],
            self::MOCK_VISITOR_ID_404_ERROR => ['file' => '404_error_visitor_not_found.json', 'status' => 404],
            self::MOCK_VISITOR_ID_429_ERROR => ['file' => '429_error_too_many_requests.json', 'status' => 429],
            self::MOCK_VISITOR_ID => ['file' => 'delete_visitor.json', 'status' => 200],
        ];

        $mock = $mockFileMap[$visitor_id];
        $file = file_get_contents(__DIR__ . "/mocks/" . $mock['file']);
        $response = new \GuzzleHttp\Psr7\Response($mock['status'], [], $file);

        if ($mock['status'] !== 200) {
            throw new ApiException("Error Processing Request", $mock['status']);
        }

        $serialized = ObjectSerializer::deserialize($response, Response::class);
        return [$serialized, $response];
    }

    /**
     * Mock PUT /events/{event_id} endpoint
     *
     * @throws SerializationException
     */
    public function updateEventWithHttpInfoMock($updateRequest, $event_id): array
    {
        $mockFileMap = [
            self::MOCK_EVENT_ID_400_ERROR => ['file' => 'update_event_400_error.json', 'status' => 400],
            self::MOCK_EVENT_ID_403_ERROR => ['file' => 'update_event_403_error.json', 'status' => 403],
            self::MOCK_EVENT_ID_404_ERROR => ['file' => 'update_event_404_error.json', 'status' => 404],
            self::MOCK_EVENT_ID_409_ERROR => ['file' => 'update_event_409_error.json', 'status' => 409],
            self::MOCK_EVENT_ID => ['file' => 'update_event.json', 'status' => 200],
        ];

        $mock = $mockFileMap[$event_id];
        $file = file_get_contents(__DIR__ . "/mocks/" . $mock['file']);
        $response = new \GuzzleHttp\Psr7\Response($mock['status'], [], $file);

        if ($mock['status'] !== 200) {
            throw new ApiException("Error Processing Request", $mock['status']);
        }

        $serialized = ObjectSerializer::deserialize($response, Response::class);
        return [$serialized, $response];
    }

    public function testGetEvent()
    {
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
        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_EXTRA_FIELDS);
        $products = $event->getProducts();
        $identification_product = $products->getIdentification();
        $request_id = $identification_product->getData()->getRequestId();
        $this->assertEquals(self::MOCK_EXTRA_FIELDS_REQUEST_ID, $request_id);
    }

    public function testGetEventWithAllErrors()
    {
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
        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID);
        $this->assertEquals($visits->getVisitorId(), self::MOCK_VISITOR_ID);
    }

    public function testGetVisitsByRequestId()
    {
        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID, self::MOCK_VISITOR_REQUEST_ID);
        foreach ($visits->getVisits() as $visit) {
            $this->assertEquals($visit->getRequestId(), self::MOCK_VISITOR_REQUEST_ID);
        }
    }

    public function testGetVisitsWithLimit()
    {
        $limit = 100;
        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID, null, $limit);
        $count = count($visits->getVisits());
        $this->assertLessThanOrEqual($limit, $count);
    }

    public function testGetEventRawResponse()
    {
        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID);
        $mockedResult = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . "/mocks/get_event_200.json"));
        $this->assertEquals($mockedResult, \GuzzleHttp\json_decode($response->getBody()->getContents()));
    }

    public function testGetVisitsRawResponse()
    {
        list($visits, $response) = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID);
        $mockedResult = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . "/mocks/get_visits_200_limit_500.json"));
        $this->assertEquals($mockedResult, \GuzzleHttp\json_decode($response->getBody()->getContents()));
    }

    public function testGetEventParsedModelWithUnknownField()
    {
        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID_WITH_UNKNOWN);
        $this->assertEquals(false, $event->getProducts()->getIncognito()->getData()->getResult());
    }

    public function testGetUnknownFieldFromEvent()
    {
        list($event, $response) = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID_WITH_UNKNOWN);
        $responseBody = \GuzzleHttp\json_decode($response->getBody()->getContents());
        $this->assertEquals("field", $responseBody->unknown);
        $this->assertEquals("field", $responseBody->products->unknown);
        $this->assertEquals("field", $responseBody->products->identification->unknown);
        $this->assertEquals("field", $responseBody->products->identification->data->unknown);
    }

    public function testGetBrokenFormatEvent()
    {
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

    public function testDeleteVisitorData() {
        list($result, $response) = $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetVisits403Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID_403_ERROR);
    }

    public function testGetVisits429Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(429);

        $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID_429_ERROR);
    }

    public function testGetEvent403Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_403_ERROR);
    }

    public function testGetEvent404Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $this->fingerprint_api->getEvent(self::MOCK_EVENT_ID_404_ERROR);
    }

    public function testDeleteVisitorData400Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_400_ERROR);
    }

    public function testDeleteVisitorData403Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_403_ERROR);
    }

    public function testDeleteVisitorData404Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_404_ERROR);
    }

    public function testDeleteVisitorData429Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(429);

        $this->fingerprint_api->deleteVisitorData(self::MOCK_VISITOR_ID_429_ERROR);
    }

    public function testUpdateEvent400Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_400_ERROR);
    }

    public function testUpdateEvent403Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_403_ERROR);
    }

    public function testUpdateEvent404Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_404_ERROR);
    }

    public function testUpdateEvent409Error()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(409);

        $this->fingerprint_api->updateEvent(new EventUpdateRequest([]), self::MOCK_EVENT_ID_409_ERROR);
    }
}
