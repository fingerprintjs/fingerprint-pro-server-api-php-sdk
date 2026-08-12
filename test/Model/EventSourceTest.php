<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\EventSource;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(EventSource::class)]
class EventSourceTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = EventSource::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(EventSource::DEVICE, $cases);
        $this->assertContains(EventSource::EDGE, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('device', EventSource::DEVICE->value);
        $this->assertEquals('edge', EventSource::EDGE->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(EventSource::DEVICE, EventSource::from('device'));
        $this->assertSame(EventSource::EDGE, EventSource::from('edge'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(EventSource::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $this->assertSame(EventSource::DEVICE, ObjectSerializer::deserialize('device', EventSource::class));
        $this->assertSame(EventSource::EDGE, ObjectSerializer::deserialize('edge', EventSource::class));
    }
}
