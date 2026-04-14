<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\ProxyConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ProxyConfidence::class)]
class ProxyConfidenceTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = ProxyConfidence::cases();
        $this->assertCount(3, $cases);
        $this->assertContains(ProxyConfidence::LOW, $cases);
        $this->assertContains(ProxyConfidence::MEDIUM, $cases);
        $this->assertContains(ProxyConfidence::HIGH, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('low', ProxyConfidence::LOW->value);
        $this->assertEquals('medium', ProxyConfidence::MEDIUM->value);
        $this->assertEquals('high', ProxyConfidence::HIGH->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(ProxyConfidence::LOW, ProxyConfidence::from('low'));
        $this->assertSame(ProxyConfidence::MEDIUM, ProxyConfidence::from('medium'));
        $this->assertSame(ProxyConfidence::HIGH, ProxyConfidence::from('high'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(ProxyConfidence::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('low', ProxyConfidence::class);
        $this->assertSame(ProxyConfidence::LOW, $deserialized);
    }
}
