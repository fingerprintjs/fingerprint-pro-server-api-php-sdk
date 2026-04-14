<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\TamperingConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(TamperingConfidence::class)]
class TamperingConfidenceTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = TamperingConfidence::cases();
        $this->assertCount(3, $cases);
        $this->assertContains(TamperingConfidence::LOW, $cases);
        $this->assertContains(TamperingConfidence::MEDIUM, $cases);
        $this->assertContains(TamperingConfidence::HIGH, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('low', TamperingConfidence::LOW->value);
        $this->assertEquals('medium', TamperingConfidence::MEDIUM->value);
        $this->assertEquals('high', TamperingConfidence::HIGH->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(TamperingConfidence::LOW, TamperingConfidence::from('low'));
        $this->assertSame(TamperingConfidence::MEDIUM, TamperingConfidence::from('medium'));
        $this->assertSame(TamperingConfidence::HIGH, TamperingConfidence::from('high'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(TamperingConfidence::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('low', TamperingConfidence::class);
        $this->assertSame(TamperingConfidence::LOW, $deserialized);
    }
}
