<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\SearchEventsRareDevicePercentileBucket;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(SearchEventsRareDevicePercentileBucket::class)]
class SearchEventsRareDevicePercentileBucketTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = SearchEventsRareDevicePercentileBucket::cases();
        $this->assertCount(6, $cases);
        $this->assertContains(SearchEventsRareDevicePercentileBucket::P95, $cases);
        $this->assertContains(SearchEventsRareDevicePercentileBucket::P95_P99, $cases);
        $this->assertContains(SearchEventsRareDevicePercentileBucket::P99_P99_5, $cases);
        $this->assertContains(SearchEventsRareDevicePercentileBucket::P99_5_P99_9, $cases);
        $this->assertContains(SearchEventsRareDevicePercentileBucket::P99_9, $cases);
        $this->assertContains(SearchEventsRareDevicePercentileBucket::NOT_SEEN, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('<p95', SearchEventsRareDevicePercentileBucket::P95->value);
        $this->assertEquals('p95-p99', SearchEventsRareDevicePercentileBucket::P95_P99->value);
        $this->assertEquals('p99-p99.5', SearchEventsRareDevicePercentileBucket::P99_P99_5->value);
        $this->assertEquals('p99.5-p99.9', SearchEventsRareDevicePercentileBucket::P99_5_P99_9->value);
        $this->assertEquals('p99.9+', SearchEventsRareDevicePercentileBucket::P99_9->value);
        $this->assertEquals('not_seen', SearchEventsRareDevicePercentileBucket::NOT_SEEN->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(SearchEventsRareDevicePercentileBucket::P95, SearchEventsRareDevicePercentileBucket::from('<p95'));
        $this->assertSame(SearchEventsRareDevicePercentileBucket::P95_P99, SearchEventsRareDevicePercentileBucket::from('p95-p99'));
        $this->assertSame(SearchEventsRareDevicePercentileBucket::P99_P99_5, SearchEventsRareDevicePercentileBucket::from('p99-p99.5'));
        $this->assertSame(SearchEventsRareDevicePercentileBucket::P99_5_P99_9, SearchEventsRareDevicePercentileBucket::from('p99.5-p99.9'));
        $this->assertSame(SearchEventsRareDevicePercentileBucket::P99_9, SearchEventsRareDevicePercentileBucket::from('p99.9+'));
        $this->assertSame(SearchEventsRareDevicePercentileBucket::NOT_SEEN, SearchEventsRareDevicePercentileBucket::from('not_seen'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     *
     * @noinspection PhpCaseWithValueNotFoundInEnumInspection
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(SearchEventsRareDevicePercentileBucket::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     *
     * @throws \DateMalformedStringException
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('<p95', SearchEventsRareDevicePercentileBucket::class);
        $this->assertSame(SearchEventsRareDevicePercentileBucket::P95, $deserialized);
    }
}
