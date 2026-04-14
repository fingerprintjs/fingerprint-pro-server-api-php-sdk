<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Identification;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Identification::class)]
class IdentificationTest extends TestCase
{
    private const EXAMPLE = [
        'visitor_id' => 'abc123',
        'visitor_found' => true,
        'first_seen_at' => 1700000000,
        'last_seen_at' => 1700001000,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Identification();

        $this->assertNull($model->getVisitorId());
        $this->assertNull($model->getConfidence());
        $this->assertNull($model->getVisitorFound());
        $this->assertNull($model->getFirstSeenAt());
        $this->assertNull($model->getLastSeenAt());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Identification(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['visitor_id'], $model->getVisitorId());
        $this->assertEquals(self::EXAMPLE['visitor_found'], $model->getVisitorFound());
        $this->assertEquals(self::EXAMPLE['first_seen_at'], $model->getFirstSeenAt());
        $this->assertEquals(self::EXAMPLE['last_seen_at'], $model->getLastSeenAt());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Identification();

        $this->assertSame($model, $model->setVisitorId(self::EXAMPLE['visitor_id']));
        $this->assertSame($model, $model->setVisitorFound(self::EXAMPLE['visitor_found']));
        $this->assertSame($model, $model->setFirstSeenAt(self::EXAMPLE['first_seen_at']));
        $this->assertSame($model, $model->setLastSeenAt(self::EXAMPLE['last_seen_at']));
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Identification(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Identification::class);

        $this->assertEquals($model->getVisitorId(), $deserialized->getVisitorId());
        $this->assertEquals($model->getVisitorFound(), $deserialized->getVisitorFound());
        $this->assertEquals($model->getFirstSeenAt(), $deserialized->getFirstSeenAt());
        $this->assertEquals($model->getLastSeenAt(), $deserialized->getLastSeenAt());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Identification();

        $model['visitor_id'] = 'xyz789';
        $this->assertEquals('xyz789', $model['visitor_id']);
        $this->assertTrue(isset($model['visitor_id']));

        unset($model['visitor_id']);
        $this->assertNull($model['visitor_id']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new Identification();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new Identification(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Identification(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['visitor_id'], $decoded['visitor_id']);
        $this->assertEquals(self::EXAMPLE['visitor_found'], $decoded['visitor_found']);
        $this->assertEquals(self::EXAMPLE['first_seen_at'], $decoded['first_seen_at']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new Identification(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('visitor_id'));
        $this->assertFalse($model->isNullableSetToNull('visitor_found'));
        $this->assertFalse($model->isNullableSetToNull('first_seen_at'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Identification();

        $this->assertEquals('Identification', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Identification();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Identification(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['visitor_id'], $serialized->visitor_id);
        $this->assertEquals(self::EXAMPLE['visitor_found'], $serialized->visitor_found);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new Identification(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['visitor_id'], $decoded['visitor_id']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['visitor_id'] = null;

        $model = new Identification($data);

        $this->assertNull($model->getVisitorId());
        $this->assertFalse($model->isNullableSetToNull('visitor_id'));
    }
}
