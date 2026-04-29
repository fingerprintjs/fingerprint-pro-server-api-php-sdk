<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\RareDevicePercentileBucket;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(RareDevicePercentileBucket::class)]
class RareDevicePercentileBucketTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = RareDevicePercentileBucket::cases();
        $this->assertCount(6, $cases);
        $this->assertContains(RareDevicePercentileBucket::P95, $cases);
        $this->assertContains(RareDevicePercentileBucket::P95_P99, $cases);
        $this->assertContains(RareDevicePercentileBucket::P99_P99_5, $cases);
        $this->assertContains(RareDevicePercentileBucket::P99_5_P99_9, $cases);
        $this->assertContains(RareDevicePercentileBucket::P99_9, $cases);
        $this->assertContains(RareDevicePercentileBucket::NOT_SEEN, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('<p95', RareDevicePercentileBucket::P95->value);
        $this->assertEquals('p95-p99', RareDevicePercentileBucket::P95_P99->value);
        $this->assertEquals('p99-p99.5', RareDevicePercentileBucket::P99_P99_5->value);
        $this->assertEquals('p99.5-p99.9', RareDevicePercentileBucket::P99_5_P99_9->value);
        $this->assertEquals('p99.9+', RareDevicePercentileBucket::P99_9->value);
        $this->assertEquals('not_seen', RareDevicePercentileBucket::NOT_SEEN->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(RareDevicePercentileBucket::P95, RareDevicePercentileBucket::from('<p95'));
        $this->assertSame(RareDevicePercentileBucket::P95_P99, RareDevicePercentileBucket::from('p95-p99'));
        $this->assertSame(RareDevicePercentileBucket::P99_P99_5, RareDevicePercentileBucket::from('p99-p99.5'));
        $this->assertSame(RareDevicePercentileBucket::P99_5_P99_9, RareDevicePercentileBucket::from('p99.5-p99.9'));
        $this->assertSame(RareDevicePercentileBucket::P99_9, RareDevicePercentileBucket::from('p99.9+'));
        $this->assertSame(RareDevicePercentileBucket::NOT_SEEN, RareDevicePercentileBucket::from('not_seen'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     *
     * @noinspection PhpCaseWithValueNotFoundInEnumInspection
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(RareDevicePercentileBucket::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     *
     * @throws \DateMalformedStringException
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('<p95', RareDevicePercentileBucket::class);
        $this->assertSame(RareDevicePercentileBucket::P95, $deserialized);
    }
}
