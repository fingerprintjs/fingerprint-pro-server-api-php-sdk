<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\RuleActionType;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(RuleActionType::class)]
class RuleActionTypeTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = RuleActionType::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(RuleActionType::ALLOW, $cases);
        $this->assertContains(RuleActionType::BLOCK, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('allow', RuleActionType::ALLOW->value);
        $this->assertEquals('block', RuleActionType::BLOCK->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(RuleActionType::ALLOW, RuleActionType::from('allow'));
        $this->assertSame(RuleActionType::BLOCK, RuleActionType::from('block'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(RuleActionType::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('allow', RuleActionType::class);
        $this->assertSame(RuleActionType::ALLOW, $deserialized);
    }
}
