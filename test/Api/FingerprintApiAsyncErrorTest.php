<?php

namespace Fingerprint\ServerSdk\Test\Api;

use Fingerprint\ServerSdk\Api\FingerprintApi;
use Fingerprint\ServerSdk\ApiException;
use Fingerprint\ServerSdk\Configuration;
use Fingerprint\ServerSdk\Model\ErrorCode;
use Fingerprint\ServerSdk\Model\ErrorResponse;
use Fingerprint\ServerSdk\Model\EventUpdate;
use Fingerprint\ServerSdk\Test\MockHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Tests that async operations correctly wrap Guzzle exceptions in ApiException.
 *
 * @internal
 */
#[CoversClass(FingerprintApi::class)]
class FingerprintApiAsyncErrorTest extends TestCase
{
    private FingerprintApi $api;
    private MockHandler $mockHandler;

    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $client = new Client(['handler' => HandlerStack::create($this->mockHandler)]);
        $this->api = new FingerprintApi(new Configuration('test-api-key'), $client);
    }

    public function testGetEventAsyncError(): void
    {
        $this->mockHandler->append(MockHelper::getMockResponse(MockHelper::OPERATION_ERROR_404_EVENT_NOT_FOUND));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->api->getEventAsync('invalid')->wait();
        } catch (ApiException $e) {
            $this->assertInstanceOf(ErrorResponse::class, $e->getErrorDetails());
            $this->assertSame(ErrorCode::EVENT_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testSearchEventsAsyncError(): void
    {
        $this->mockHandler->append(MockHelper::getMockResponse(MockHelper::OPERATION_ERROR_403_WRONG_REGION));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        try {
            $this->api->searchEventsAsync()->wait();
        } catch (ApiException $e) {
            $this->assertInstanceOf(ErrorResponse::class, $e->getErrorDetails());
            $this->assertSame(ErrorCode::WRONG_REGION, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testDeleteVisitorDataAsyncError(): void
    {
        $this->mockHandler->append(MockHelper::getMockResponse(MockHelper::OPERATION_ERROR_400_VISITOR_ID_INVALID));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        try {
            $this->api->deleteVisitorDataAsync('invalid')->wait();
        } catch (ApiException $e) {
            $this->assertInstanceOf(ErrorResponse::class, $e->getErrorDetails());
            $this->assertSame(ErrorCode::REQUEST_CANNOT_BE_PARSED, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }

    public function testUpdateEventAsyncError(): void
    {
        $this->mockHandler->append(MockHelper::getMockResponse(MockHelper::OPERATION_ERROR_404_EVENT_NOT_FOUND));

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        try {
            $this->api->updateEventAsync('invalid', new EventUpdate())->wait();
        } catch (ApiException $e) {
            $this->assertInstanceOf(ErrorResponse::class, $e->getErrorDetails());
            $this->assertSame(ErrorCode::EVENT_NOT_FOUND, $e->getErrorDetails()->getError()->getCode());

            throw $e;
        }
    }
}
