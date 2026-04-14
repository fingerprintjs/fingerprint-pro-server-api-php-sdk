<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\VpnConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(VpnConfidence::class)]
class VpnConfidenceTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = VpnConfidence::cases();
        $this->assertCount(3, $cases);
        $this->assertContains(VpnConfidence::LOW, $cases);
        $this->assertContains(VpnConfidence::MEDIUM, $cases);
        $this->assertContains(VpnConfidence::HIGH, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('low', VpnConfidence::LOW->value);
        $this->assertEquals('medium', VpnConfidence::MEDIUM->value);
        $this->assertEquals('high', VpnConfidence::HIGH->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(VpnConfidence::LOW, VpnConfidence::from('low'));
        $this->assertSame(VpnConfidence::MEDIUM, VpnConfidence::from('medium'));
        $this->assertSame(VpnConfidence::HIGH, VpnConfidence::from('high'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(VpnConfidence::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('low', VpnConfidence::class);
        $this->assertSame(VpnConfidence::LOW, $deserialized);
    }
}
