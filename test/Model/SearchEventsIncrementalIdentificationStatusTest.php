<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\SearchEventsIncrementalIdentificationStatus;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(SearchEventsIncrementalIdentificationStatus::class)]
class SearchEventsIncrementalIdentificationStatusTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = SearchEventsIncrementalIdentificationStatus::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(SearchEventsIncrementalIdentificationStatus::PARTIALLY_COMPLETED, $cases);
        $this->assertContains(SearchEventsIncrementalIdentificationStatus::COMPLETED, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('partially_completed', SearchEventsIncrementalIdentificationStatus::PARTIALLY_COMPLETED->value);
        $this->assertEquals('completed', SearchEventsIncrementalIdentificationStatus::COMPLETED->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(SearchEventsIncrementalIdentificationStatus::PARTIALLY_COMPLETED, SearchEventsIncrementalIdentificationStatus::from('partially_completed'));
        $this->assertSame(SearchEventsIncrementalIdentificationStatus::COMPLETED, SearchEventsIncrementalIdentificationStatus::from('completed'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(SearchEventsIncrementalIdentificationStatus::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('partially_completed', SearchEventsIncrementalIdentificationStatus::class);
        $this->assertSame(SearchEventsIncrementalIdentificationStatus::PARTIALLY_COMPLETED, $deserialized);
    }
}
