<?php

namespace Fingerprint\ServerAPI;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SerializationExceptionTest extends TestCase
{
    public function testSetResponseOverridesConstructorValue(): void
    {
        $initialResponse = new Response(400);
        $exception = new SerializationException($initialResponse);

        $this->assertSame($initialResponse, $exception->getResponse());

        $newResponse = new Response(500);
        $exception->setResponse($newResponse);

        $this->assertSame($newResponse, $exception->getResponse());
    }

    public function testSetResponseOnNullInitialResponse(): void
    {
        $exception = new SerializationException();

        $this->assertNull($exception->getResponse());
    }
}
