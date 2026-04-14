<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\SearchEventsBot;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(SearchEventsBot::class)]
class SearchEventsBotTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = SearchEventsBot::cases();
        $this->assertCount(4, $cases);
        $this->assertContains(SearchEventsBot::ALL, $cases);
        $this->assertContains(SearchEventsBot::GOOD, $cases);
        $this->assertContains(SearchEventsBot::BAD, $cases);
        $this->assertContains(SearchEventsBot::NONE, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('all', SearchEventsBot::ALL->value);
        $this->assertEquals('good', SearchEventsBot::GOOD->value);
        $this->assertEquals('bad', SearchEventsBot::BAD->value);
        $this->assertEquals('none', SearchEventsBot::NONE->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(SearchEventsBot::ALL, SearchEventsBot::from('all'));
        $this->assertSame(SearchEventsBot::GOOD, SearchEventsBot::from('good'));
        $this->assertSame(SearchEventsBot::BAD, SearchEventsBot::from('bad'));
        $this->assertSame(SearchEventsBot::NONE, SearchEventsBot::from('none'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(SearchEventsBot::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('all', SearchEventsBot::class);
        $this->assertSame(SearchEventsBot::ALL, $deserialized);
    }
}
