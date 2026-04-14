<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\EventRuleActionBlock;
use Fingerprint\ServerSdk\Model\RuleActionType;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(EventRuleActionBlock::class)]
class EventRuleActionBlockTest extends TestCase
{
    private const EXAMPLE = [
        'ruleset_id' => 'rs-001',
        'rule_id' => 'rule-99',
        'rule_expression' => 'bot.result == "bad_bot"',
        'type' => RuleActionType::BLOCK,
        'status_code' => 403,
        'body' => 'Blocked',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new EventRuleActionBlock();

        $this->assertNull($model->getRulesetId());
        $this->assertNull($model->getRuleId());
        $this->assertNull($model->getRuleExpression());
        $this->assertNull($model->getType());
        $this->assertNull($model->getStatusCode());
        $this->assertNull($model->getHeaders());
        $this->assertNull($model->getBody());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new EventRuleActionBlock(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['ruleset_id'], $model->getRulesetId());
        $this->assertEquals(self::EXAMPLE['rule_id'], $model->getRuleId());
        $this->assertEquals(self::EXAMPLE['rule_expression'], $model->getRuleExpression());
        $this->assertEquals(self::EXAMPLE['type'], $model->getType());
        $this->assertEquals(self::EXAMPLE['status_code'], $model->getStatusCode());
        $this->assertEquals(self::EXAMPLE['body'], $model->getBody());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new EventRuleActionBlock();

        $this->assertSame($model, $model->setRulesetId(self::EXAMPLE['ruleset_id']));
        $this->assertSame($model, $model->setRuleId(self::EXAMPLE['rule_id']));
        $this->assertSame($model, $model->setRuleExpression(self::EXAMPLE['rule_expression']));
        $this->assertSame($model, $model->setType(self::EXAMPLE['type']));
        $this->assertSame($model, $model->setStatusCode(self::EXAMPLE['status_code']));
        $this->assertSame($model, $model->setHeaders([]));
        $this->assertSame($model, $model->setBody(self::EXAMPLE['body']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new EventRuleActionBlock(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), EventRuleActionBlock::class);

        $this->assertEquals($model->getRulesetId(), $deserialized->getRulesetId());
        $this->assertEquals($model->getRuleId(), $deserialized->getRuleId());
        $this->assertEquals($model->getRuleExpression(), $deserialized->getRuleExpression());
        $this->assertEquals($model->getStatusCode(), $deserialized->getStatusCode());
        $this->assertEquals($model->getBody(), $deserialized->getBody());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new EventRuleActionBlock();

        $model['ruleset_id'] = self::EXAMPLE['ruleset_id'];
        $this->assertEquals(self::EXAMPLE['ruleset_id'], $model['ruleset_id']);
        $this->assertTrue(isset($model['ruleset_id']));

        unset($model['ruleset_id']);
        $this->assertNull($model['ruleset_id']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not (has required props).
     */
    public function testValidation(): void
    {
        $emptyModel = new EventRuleActionBlock();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new EventRuleActionBlock(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new EventRuleActionBlock(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['ruleset_id'], $decoded['ruleset_id']);
        $this->assertEquals(self::EXAMPLE['status_code'], $decoded['status_code']);
        $this->assertEquals(self::EXAMPLE['body'], $decoded['body']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new EventRuleActionBlock();

        $this->assertEquals('EventRuleActionBlock', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new EventRuleActionBlock();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new EventRuleActionBlock(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['ruleset_id'], $serialized->ruleset_id);
        $this->assertEquals(self::EXAMPLE['status_code'], $serialized->status_code);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new EventRuleActionBlock(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['ruleset_id'], $decoded['ruleset_id']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new EventRuleActionBlock(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('ruleset_id'));
        $this->assertFalse($model->isNullableSetToNull('type'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['ruleset_id'] = null;

        $model = new EventRuleActionBlock($data);

        $this->assertNull($model->getRulesetId());
        $this->assertFalse($model->isNullableSetToNull('ruleset_id'));
    }
}
