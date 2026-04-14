<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\RuleActionHeaderField;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(RuleActionHeaderField::class)]
class RuleActionHeaderFieldTest extends TestCase
{
    private const EXAMPLE = [
        'name' => 'X-Custom-Header',
        'value' => 'custom-value',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new RuleActionHeaderField();

        $this->assertNull($model->getName());
        $this->assertNull($model->getValue());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new RuleActionHeaderField(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['name'], $model->getName());
        $this->assertEquals(self::EXAMPLE['value'], $model->getValue());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new RuleActionHeaderField();

        $this->assertSame($model, $model->setName(self::EXAMPLE['name']));
        $this->assertSame($model, $model->setValue(self::EXAMPLE['value']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new RuleActionHeaderField(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), RuleActionHeaderField::class);

        $this->assertEquals($model->getName(), $deserialized->getName());
        $this->assertEquals($model->getValue(), $deserialized->getValue());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new RuleActionHeaderField();

        $model['name'] = self::EXAMPLE['name'];
        $this->assertEquals(self::EXAMPLE['name'], $model['name']);
        $this->assertTrue(isset($model['name']));

        unset($model['name']);
        $this->assertNull($model['name']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not because name and value are required.
     */
    public function testValidation(): void
    {
        $emptyModel = new RuleActionHeaderField();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new RuleActionHeaderField(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new RuleActionHeaderField(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
        $this->assertEquals(self::EXAMPLE['value'], $decoded['value']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new RuleActionHeaderField();

        $this->assertEquals('RuleActionHeaderField', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new RuleActionHeaderField();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new RuleActionHeaderField(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['name'], $serialized->name);
        $this->assertEquals(self::EXAMPLE['value'], $serialized->value);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new RuleActionHeaderField(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
