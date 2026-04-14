<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\EventUpdate;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(EventUpdate::class)]
class EventUpdateTest extends TestCase
{
    private const EXAMPLE = [
        'linked_id' => 'link-1',
        'tags' => ['key' => 'value'],
        'suspect' => false,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new EventUpdate();

        $this->assertNull($model->getLinkedId());
        $this->assertNull($model->getTags());
        $this->assertNull($model->getSuspect());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new EventUpdate(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['linked_id'], $model->getLinkedId());
        $this->assertEquals(self::EXAMPLE['tags'], $model->getTags());
        $this->assertEquals(self::EXAMPLE['suspect'], $model->getSuspect());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new EventUpdate();

        $this->assertSame($model, $model->setLinkedId(self::EXAMPLE['linked_id']));
        $this->assertSame($model, $model->setTags(self::EXAMPLE['tags']));
        $this->assertSame($model, $model->setSuspect(self::EXAMPLE['suspect']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new EventUpdate(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), EventUpdate::class);

        $this->assertEquals($model->getLinkedId(), $deserialized->getLinkedId());
        $this->assertEquals($model->getSuspect(), $deserialized->getSuspect());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new EventUpdate();

        $model['linked_id'] = self::EXAMPLE['linked_id'];
        $this->assertEquals(self::EXAMPLE['linked_id'], $model['linked_id']);
        $this->assertTrue(isset($model['linked_id']));

        unset($model['linked_id']);
        $this->assertNull($model['linked_id']);
    }

    /**
     * An empty model should be valid since EventUpdate has no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new EventUpdate();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $populatedModel = new EventUpdate(self::EXAMPLE);
        $this->assertTrue($populatedModel->valid());
        $this->assertEmpty($populatedModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new EventUpdate(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['linked_id'], $decoded['linked_id']);
        $this->assertFalse($decoded['suspect']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new EventUpdate();

        $this->assertEquals('EventUpdate', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new EventUpdate();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new EventUpdate(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['linked_id'], $serialized->linked_id);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new EventUpdate(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['linked_id'], $decoded['linked_id']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new EventUpdate(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('linked_id'));
        $this->assertFalse($model->isNullableSetToNull('suspect'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['linked_id'] = null;

        $model = new EventUpdate($data);

        $this->assertNull($model->getLinkedId());
        $this->assertFalse($model->isNullableSetToNull('linked_id'));
    }
}
