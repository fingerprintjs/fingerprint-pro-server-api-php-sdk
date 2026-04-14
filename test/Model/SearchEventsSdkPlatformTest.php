<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\SearchEventsSdkPlatform;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(SearchEventsSdkPlatform::class)]
class SearchEventsSdkPlatformTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = SearchEventsSdkPlatform::cases();
        $this->assertCount(3, $cases);
        $this->assertContains(SearchEventsSdkPlatform::JS, $cases);
        $this->assertContains(SearchEventsSdkPlatform::ANDROID, $cases);
        $this->assertContains(SearchEventsSdkPlatform::IOS, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('js', SearchEventsSdkPlatform::JS->value);
        $this->assertEquals('android', SearchEventsSdkPlatform::ANDROID->value);
        $this->assertEquals('ios', SearchEventsSdkPlatform::IOS->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(SearchEventsSdkPlatform::JS, SearchEventsSdkPlatform::from('js'));
        $this->assertSame(SearchEventsSdkPlatform::ANDROID, SearchEventsSdkPlatform::from('android'));
        $this->assertSame(SearchEventsSdkPlatform::IOS, SearchEventsSdkPlatform::from('ios'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(SearchEventsSdkPlatform::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('js', SearchEventsSdkPlatform::class);
        $this->assertSame(SearchEventsSdkPlatform::JS, $deserialized);
    }
}
