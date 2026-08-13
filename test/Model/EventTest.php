<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Event;
use Fingerprint\ServerSdk\Model\EventSource;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Event::class)]
class EventTest extends TestCase
{
    private const EXAMPLE = [
        'event_id' => 'evt-123',
        'timestamp' => 1700000000,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Event();

        $this->assertNull($model->getEventId());
        $this->assertNull($model->getTimestamp());
        $this->assertNull($model->getLinkedId());
        $this->assertNull($model->getRuleAction());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Event(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['event_id'], $model->getEventId());
        $this->assertEquals(self::EXAMPLE['timestamp'], $model->getTimestamp());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Event();

        $this->assertSame($model, $model->setEventId(self::EXAMPLE['event_id']));
        $this->assertSame($model, $model->setTimestamp(self::EXAMPLE['timestamp']));
        $this->assertSame($model, $model->setLinkedId('link-1'));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Event(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Event::class);

        $this->assertEquals($model->getEventId(), $deserialized->getEventId());
        $this->assertEquals($model->getTimestamp(), $deserialized->getTimestamp());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Event();

        $model['event_id'] = self::EXAMPLE['event_id'];
        $this->assertEquals(self::EXAMPLE['event_id'], $model['event_id']);
        $this->assertTrue(isset($model['event_id']));

        unset($model['event_id']);
        $this->assertNull($model['event_id']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not (has required props).
     */
    public function testValidation(): void
    {
        $emptyModel = new Event();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new Event(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Event(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['event_id'], $decoded['event_id']);
        $this->assertEquals(self::EXAMPLE['timestamp'], $decoded['timestamp']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Event();

        $this->assertEquals('Event', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Event();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Event(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['event_id'], $serialized->event_id);
        $this->assertEquals(self::EXAMPLE['timestamp'], $serialized->timestamp);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new Event(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['event_id'], $decoded['event_id']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new Event(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('event_id'));
        $this->assertFalse($model->isNullableSetToNull('timestamp'));
    }

    /**
     * Deserializing an event should map the source values to the matching enum cases.
     *
     * @throws \DateMalformedStringException
     */
    public function testDeserializationWithSource(): void
    {
        foreach ([EventSource::DEVICE, EventSource::EDGE] as $expected) {
            $json = json_encode(self::EXAMPLE + ['source' => $expected->value]);

            /** @var Event $model */
            $model = ObjectSerializer::deserialize(json_decode($json), Event::class);

            $this->assertSame($expected, $model->getSource());
        }
    }

    /**
     * Source is optional, so an event payload without it should deserialize with a null source.
     *
     * @throws \DateMalformedStringException
     */
    public function testDeserializationWithoutSource(): void
    {
        $json = json_encode(self::EXAMPLE);

        /** @var Event $model */
        $model = ObjectSerializer::deserialize(json_decode($json), Event::class);

        $this->assertNull($model->getSource());
        $this->assertTrue($model->valid());
    }

    /**
     * Deserializing a JSON response with an unknown source should not throw.
     * The unknown value should be preserved through deserialization and re-serialization.
     *
     * @throws \DateMalformedStringException
     */
    public function testDeserializationWithUnknownSource(): void
    {
        $json = json_encode(self::EXAMPLE + ['source' => 'unknown-value']);

        /** @var Event $model */
        $model = ObjectSerializer::deserialize(json_decode($json), Event::class);

        $this->assertEquals('unknown-value', $model->getSource());
        $this->assertTrue($model->valid());

        // Re-serialization should preserve the unknown value
        $reserialized = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $decoded = json_decode($reserialized, true);
        $this->assertEquals('unknown-value', $decoded['source']);
    }

    /**
     * setSource should accept unknown enum values without throwing.
     */
    public function testSetSourceAcceptsUnknownValue(): void
    {
        $model = new Event();

        $model->setSource('unknown-value');
        $this->assertEquals('unknown-value', $model->getSource());
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['event_id'] = null;

        $model = new Event($data);

        $this->assertNull($model->getEventId());
        $this->assertFalse($model->isNullableSetToNull('event_id'));
    }
}
