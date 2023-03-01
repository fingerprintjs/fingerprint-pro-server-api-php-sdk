<?php

namespace Fingerprint\ServerAPI;

use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Model\EventResponse;
use Fingerprint\ServerAPI\Model\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class FingerprintApiTest extends TestCase
{
    /** @var FingerprintApi */
    protected $fingerprint_api;

    const MOCK_REQUEST_ID = '0KSh65EnVoB85JBmloQK';
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

    public function getEventMock()
    {
        $event_request_method = $this->getMethod('getEventRequest');
        /** @var \GuzzleHttp\Psr7\Request $event_request */
        $event_request = $event_request_method->invokeArgs($this->fingerprint_api, [self::MOCK_REQUEST_ID]);
        $query = $event_request->getUri()->getQuery();
        $this->assertStringContainsString("ii=" . urlencode("fingerprint-pro-server-php-sdk/" . $this->getVersion()), $query);
        $events_mock_data = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . '/mocks/get_event.json'));
        return ObjectSerializer::deserialize($events_mock_data, EventResponse::class);
    }

    public function getVisitsMock($visitor_id, $request_id = null, $linked_id = null, $limit = null, $before = null)
    {
        $visits_mock_data = \GuzzleHttp\json_decode(file_get_contents(__DIR__ . '/mocks/visits_limit_500.json'));
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
        $request_id = $identification_product->getData()->getRequestId();
        $this->assertEquals(self::MOCK_REQUEST_ID, $request_id);
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
