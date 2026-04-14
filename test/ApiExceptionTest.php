<?php

namespace Fingerprint\ServerSdk\Test;

use Fingerprint\ServerSdk\ApiException;
use Fingerprint\ServerSdk\Model\ErrorResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ApiException::class)]
class ApiExceptionTest extends TestCase
{
    /**
     * Constructor should set message, code, response, and previous exception.
     */
    public function testConstructor(): void
    {
        $previous = new \RuntimeException('cause');
        $response = new Response(404);
        $exception = new ApiException('Not found', 404, $response, $previous);

        $this->assertEquals('Not found', $exception->getMessage());
        $this->assertEquals(404, $exception->getCode());
        $this->assertSame($response, $exception->getResponseObject());
        $this->assertSame($previous, $exception->getPrevious());
    }

    /**
     * Constructor with defaults should set empty message, zero code, and null response.
     */
    public function testConstructorDefaults(): void
    {
        $exception = new ApiException();

        $this->assertEquals('', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getResponseObject());
        $this->assertNull($exception->getPrevious());
    }

    /**
     * getResponseObject should return the response passed to the constructor.
     */
    public function testGetResponseObject(): void
    {
        $response = new Response(500, [], 'Internal Server Error');
        $exception = new ApiException('Error', 500, $response);

        $this->assertSame($response, $exception->getResponseObject());
    }

    /**
     * getResponseObject should return null when no response is provided.
     */
    public function testGetResponseObjectReturnsNull(): void
    {
        $exception = new ApiException('Error', 500);

        $this->assertNull($exception->getResponseObject());
    }

    /**
     * setErrorDetails and getErrorDetails should store and retrieve the error model.
     */
    public function testSetAndGetErrorDetails(): void
    {
        $exception = new ApiException('Error', 400);
        $errorResponse = new ErrorResponse();

        $exception->setErrorDetails($errorResponse);

        $this->assertSame($errorResponse, $exception->getErrorDetails());
    }

    /**
     * retryAfter should default to null and be settable.
     */
    public function testSetAndGetRetryAfter(): void
    {
        $exception = new ApiException('Too many requests', 429);

        $this->assertNull($exception->getRetryAfter());

        $exception->setRetryAfter(60);
        $this->assertEquals(60, $exception->getRetryAfter());
    }

    /**
     * setRetryAfter with null should reset the retry-after value.
     */
    public function testSetRetryAfterNull(): void
    {
        $exception = new ApiException('Too many requests', 429);
        $exception->setRetryAfter(30);
        $exception->setRetryAfter(null);

        $this->assertNull($exception->getRetryAfter());
    }

    /**
     * ApiException should be an instance of Exception.
     */
    public function testIsException(): void
    {
        $exception = new ApiException('test');

        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
