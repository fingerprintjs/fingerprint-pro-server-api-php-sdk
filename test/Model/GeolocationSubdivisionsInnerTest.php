<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\GeolocationSubdivisionsInner;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(GeolocationSubdivisionsInner::class)]
class GeolocationSubdivisionsInnerTest extends TestCase
{
    private const EXAMPLE = [
        'iso_code' => 'CA',
        'name' => 'California',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new GeolocationSubdivisionsInner();

        $this->assertNull($model->getIsoCode());
        $this->assertNull($model->getName());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new GeolocationSubdivisionsInner(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['iso_code'], $model->getIsoCode());
        $this->assertEquals(self::EXAMPLE['name'], $model->getName());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new GeolocationSubdivisionsInner();

        $this->assertSame($model, $model->setIsoCode(self::EXAMPLE['iso_code']));
        $this->assertSame($model, $model->setName(self::EXAMPLE['name']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new GeolocationSubdivisionsInner(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), GeolocationSubdivisionsInner::class);

        $this->assertEquals($model->getIsoCode(), $deserialized->getIsoCode());
        $this->assertEquals($model->getName(), $deserialized->getName());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new GeolocationSubdivisionsInner();

        $model['iso_code'] = self::EXAMPLE['iso_code'];
        $this->assertEquals(self::EXAMPLE['iso_code'], $model['iso_code']);
        $this->assertTrue(isset($model['iso_code']));

        unset($model['iso_code']);
        $this->assertNull($model['iso_code']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not (has required props).
     */
    public function testValidation(): void
    {
        $emptyModel = new GeolocationSubdivisionsInner();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new GeolocationSubdivisionsInner(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new GeolocationSubdivisionsInner(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['iso_code'], $decoded['iso_code']);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new GeolocationSubdivisionsInner();

        $this->assertEquals('Geolocation_subdivisions_inner', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new GeolocationSubdivisionsInner();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new GeolocationSubdivisionsInner(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['iso_code'], $serialized->iso_code);
        $this->assertEquals(self::EXAMPLE['name'], $serialized->name);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new GeolocationSubdivisionsInner(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['iso_code'], $decoded['iso_code']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new GeolocationSubdivisionsInner(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('iso_code'));
        $this->assertFalse($model->isNullableSetToNull('name'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['iso_code'] = null;

        $model = new GeolocationSubdivisionsInner($data);

        $this->assertNull($model->getIsoCode());
        $this->assertFalse($model->isNullableSetToNull('iso_code'));
    }
}
