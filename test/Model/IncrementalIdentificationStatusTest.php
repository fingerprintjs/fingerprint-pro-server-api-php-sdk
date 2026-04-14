<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\IncrementalIdentificationStatus;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(IncrementalIdentificationStatus::class)]
class IncrementalIdentificationStatusTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = IncrementalIdentificationStatus::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(IncrementalIdentificationStatus::PARTIALLY_COMPLETED, $cases);
        $this->assertContains(IncrementalIdentificationStatus::COMPLETED, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('partially_completed', IncrementalIdentificationStatus::PARTIALLY_COMPLETED->value);
        $this->assertEquals('completed', IncrementalIdentificationStatus::COMPLETED->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(IncrementalIdentificationStatus::PARTIALLY_COMPLETED, IncrementalIdentificationStatus::from('partially_completed'));
        $this->assertSame(IncrementalIdentificationStatus::COMPLETED, IncrementalIdentificationStatus::from('completed'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(IncrementalIdentificationStatus::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('partially_completed', IncrementalIdentificationStatus::class);
        $this->assertSame(IncrementalIdentificationStatus::PARTIALLY_COMPLETED, $deserialized);
    }
}
