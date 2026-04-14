<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\SearchEventsVpnConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(SearchEventsVpnConfidence::class)]
class SearchEventsVpnConfidenceTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = SearchEventsVpnConfidence::cases();
        $this->assertCount(3, $cases);
        $this->assertContains(SearchEventsVpnConfidence::HIGH, $cases);
        $this->assertContains(SearchEventsVpnConfidence::MEDIUM, $cases);
        $this->assertContains(SearchEventsVpnConfidence::LOW, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('high', SearchEventsVpnConfidence::HIGH->value);
        $this->assertEquals('medium', SearchEventsVpnConfidence::MEDIUM->value);
        $this->assertEquals('low', SearchEventsVpnConfidence::LOW->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(SearchEventsVpnConfidence::HIGH, SearchEventsVpnConfidence::from('high'));
        $this->assertSame(SearchEventsVpnConfidence::MEDIUM, SearchEventsVpnConfidence::from('medium'));
        $this->assertSame(SearchEventsVpnConfidence::LOW, SearchEventsVpnConfidence::from('low'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(SearchEventsVpnConfidence::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('high', SearchEventsVpnConfidence::class);
        $this->assertSame(SearchEventsVpnConfidence::HIGH, $deserialized);
    }
}
