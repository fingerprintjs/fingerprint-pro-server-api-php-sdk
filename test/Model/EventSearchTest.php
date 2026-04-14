<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\EventSearch;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(EventSearch::class)]
class EventSearchTest extends TestCase
{
    private const EXAMPLE = [
        'events' => [],
        'pagination_key' => 'abc',
        'total_hits' => 100,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new EventSearch();

        $this->assertNull($model->getEvents());
        $this->assertNull($model->getPaginationKey());
        $this->assertNull($model->getTotalHits());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new EventSearch(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['events'], $model->getEvents());
        $this->assertEquals(self::EXAMPLE['pagination_key'], $model->getPaginationKey());
        $this->assertEquals(self::EXAMPLE['total_hits'], $model->getTotalHits());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new EventSearch();

        $this->assertSame($model, $model->setEvents(self::EXAMPLE['events']));
        $this->assertSame($model, $model->setPaginationKey(self::EXAMPLE['pagination_key']));
        $this->assertSame($model, $model->setTotalHits(self::EXAMPLE['total_hits']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new EventSearch(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), EventSearch::class);

        $this->assertEquals($model->getEvents(), $deserialized->getEvents());
        $this->assertEquals($model->getPaginationKey(), $deserialized->getPaginationKey());
        $this->assertEquals($model->getTotalHits(), $deserialized->getTotalHits());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new EventSearch();

        $model['pagination_key'] = self::EXAMPLE['pagination_key'];
        $this->assertEquals(self::EXAMPLE['pagination_key'], $model['pagination_key']);
        $this->assertTrue(isset($model['pagination_key']));

        unset($model['pagination_key']);
        $this->assertNull($model['pagination_key']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not (events is required).
     */
    public function testValidation(): void
    {
        $emptyModel = new EventSearch();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new EventSearch(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new EventSearch(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['pagination_key'], $decoded['pagination_key']);
        $this->assertEquals(self::EXAMPLE['total_hits'], $decoded['total_hits']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new EventSearch();

        $this->assertEquals('EventSearch', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new EventSearch();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new EventSearch(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['pagination_key'], $serialized->pagination_key);
        $this->assertEquals(self::EXAMPLE['total_hits'], $serialized->total_hits);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new EventSearch(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['pagination_key'], $decoded['pagination_key']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new EventSearch(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('events'));
        $this->assertFalse($model->isNullableSetToNull('pagination_key'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['pagination_key'] = null;

        $model = new EventSearch($data);

        $this->assertNull($model->getPaginationKey());
        $this->assertFalse($model->isNullableSetToNull('pagination_key'));
    }
}
