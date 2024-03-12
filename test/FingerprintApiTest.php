<?php

namespace Fingerprint\ServerAPI;

use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Model\EventResponse;
use Fingerprint\ServerAPI\Model\IdentificationError;
use Fingerprint\ServerAPI\Model\ProductError;
use Fingerprint\ServerAPI\Model\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class FingerprintApiTest extends TestCase
{
    /** @var FingerprintApi */
    protected $fingerprint_api;

    const MOCK_REQUEST_ID = '1708102555327.NLOjmg';
    const MOCK_EXTRA_FIELDS_REQUEST_ID = '0KSh65EnVoB85JBmloQK';
    const MOCK_REQUEST_ALL_ERRORS = 'ALL_ERRORS';
    const MOCK_REQUEST_EXTRA_FIELDS = 'EXTRA_FIELDS';
    const MOCK_VISITOR_ID = 'AcxioeQKffpXF8iGQK3P';
    const MOCK_VISITOR_REQUEST_ID = '1655373780901.HhjRFX';

    protected function getMethod($method_name)
    {
        $class = new ReflectionClass(FingerprintApi::class);
        $get_event_request_method = $class->getMethod($method_name);
        $get_event_request_method->setAccessible(true);
        return $get_event_request_method;
    }

    protected function getVersion()
    {
        $config_file = file_get_contents(__DIR__ . '/../config.json');
        $config = json_decode($config_file, true);

        return $config['artifactVersion'];
    }

    public function setUp(): void
    {
        $config = new Configuration();
        $config->setHost(getenv('FP_API_HOST'));
        $config->setApiKey('api_key', getenv('FP_PRIVATE_API_KEY'));
        $this->fingerprint_api = $this->getMockBuilder(FingerprintApi::class)
            ->getMock();

        $this->fingerprint_api->method('getEvent')->will($this->returnCallback([$this, 'getEventMock']));
        $this->fingerprint_api->method('getVisits')->will($this->returnCallback([$this, 'getVisitsMock']));
    }

    public function getEventMock($request_id)
    {
        $event_request_method = $this->getMethod('getEventRequest');
        /** @var \GuzzleHttp\Psr7\Request $event_request */
        $event_request = $event_request_method->invokeArgs($this->fingerprint_api, [self::MOCK_REQUEST_ID]);
        $query = $event_request->getUri()->getQuery();
        $this->assertStringContainsString("ii=" . urlencode("fingerprint-pro-server-php-sdk/" . $this->getVersion()), $query);
        $mock_name = '';
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
        }
        $events_mock_data = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . "/mocks/$mock_name"));
        return ObjectSerializer::deserialize($events_mock_data, EventResponse::class);
    }

    public function getVisitsMock($visitor_id, $request_id = null, $linked_id = null, $limit = null, $before = null)
    {
        $visits_mock_data = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . '/mocks/get_visits_200_limit_500.json'));
        if ($request_id) {
            $visits_mock_data->visits = array_filter($visits_mock_data->visits, function ($item) use ($request_id) {
                return $item->requestId = $request_id;
            });
        }

        if ($limit && is_numeric($limit)) {
            $visits_mock_data->visits = array_slice($visits_mock_data->visits, 0, $limit);
        }
        return ObjectSerializer::deserialize($visits_mock_data, Response::class);
    }

    public function testGetEvent()
    {
        $event = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ID);
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
        var_dump($botd_product->getData()->getBot()->getResult());
        $this->assertEquals('notDetected', $botd_product->getData()->getBot()->getResult());
        $this->assertFalse( $vpn_product->getData()->getMethods()->getPublicVpn());
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
        $this->assertTrue( $raw_device_attributes['cookiesEnabled']->value);

        $location_spuffing = $products->getLocationSpoofing()->getData();
        $this->assertFalse( $location_spuffing->getResult());

        $high_activity = $products->getHighActivity()->getData();
        $this->assertFalse( $high_activity->getResult());
    }

    public function testGetEventWithExtraFields()
    {
        $event = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_EXTRA_FIELDS);
        $products = $event->getProducts();
        $identification_product = $products->getIdentification();
        $request_id = $identification_product->getData()->getRequestId();
        $this->assertEquals(self::MOCK_EXTRA_FIELDS_REQUEST_ID, $request_id);
    }

    public function testGetEventWithAllErrors()
    {
        $event = $this->fingerprint_api->getEvent(self::MOCK_REQUEST_ALL_ERRORS);
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
        $visits = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID);
        $this->assertEquals($visits->getVisitorId(), self::MOCK_VISITOR_ID);
    }

    public function testGetVisitsByRequestId()
    {
        $visits = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID, self::MOCK_VISITOR_REQUEST_ID);
        foreach ($visits->getVisits() as $visit) {
            $this->assertEquals(self::MOCK_VISITOR_REQUEST_ID, $visit->getRequestId());
        }
    }

    public function testGetVisitsWithLimit()
    {
        $limit = 100;
        $visits = $this->fingerprint_api->getVisits(self::MOCK_VISITOR_ID, null, $limit);
        $count = count($visits->getVisits());
        $this->assertLessThanOrEqual($limit, $count);
    }
}
