<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Geolocation;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Geolocation::class)]
class GeolocationTest extends TestCase
{
    private const EXAMPLE = [
        'accuracy_radius' => 10,
        'latitude' => 51.5,
        'longitude' => -0.12,
        'postal_code' => 'SW1A 1AA',
        'timezone' => 'Europe/London',
        'city_name' => 'London',
        'country_code' => 'GB',
        'country_name' => 'United Kingdom',
        'continent_code' => 'EU',
        'continent_name' => 'Europe',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Geolocation();

        $this->assertNull($model->getAccuracyRadius());
        $this->assertNull($model->getLatitude());
        $this->assertNull($model->getLongitude());
        $this->assertNull($model->getPostalCode());
        $this->assertNull($model->getTimezone());
        $this->assertNull($model->getCityName());
        $this->assertNull($model->getCountryCode());
        $this->assertNull($model->getCountryName());
        $this->assertNull($model->getContinentCode());
        $this->assertNull($model->getContinentName());
        $this->assertNull($model->getSubdivisions());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Geolocation(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['accuracy_radius'], $model->getAccuracyRadius());
        $this->assertEquals(self::EXAMPLE['latitude'], $model->getLatitude());
        $this->assertEquals(self::EXAMPLE['longitude'], $model->getLongitude());
        $this->assertEquals(self::EXAMPLE['postal_code'], $model->getPostalCode());
        $this->assertEquals(self::EXAMPLE['timezone'], $model->getTimezone());
        $this->assertEquals(self::EXAMPLE['city_name'], $model->getCityName());
        $this->assertEquals(self::EXAMPLE['country_code'], $model->getCountryCode());
        $this->assertEquals(self::EXAMPLE['country_name'], $model->getCountryName());
        $this->assertEquals(self::EXAMPLE['continent_code'], $model->getContinentCode());
        $this->assertEquals(self::EXAMPLE['continent_name'], $model->getContinentName());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Geolocation();

        $this->assertSame($model, $model->setAccuracyRadius(self::EXAMPLE['accuracy_radius']));
        $this->assertSame($model, $model->setLatitude(self::EXAMPLE['latitude']));
        $this->assertSame($model, $model->setLongitude(self::EXAMPLE['longitude']));
        $this->assertSame($model, $model->setPostalCode(self::EXAMPLE['postal_code']));
        $this->assertSame($model, $model->setTimezone(self::EXAMPLE['timezone']));
        $this->assertSame($model, $model->setCityName(self::EXAMPLE['city_name']));
        $this->assertSame($model, $model->setCountryCode(self::EXAMPLE['country_code']));
        $this->assertSame($model, $model->setCountryName(self::EXAMPLE['country_name']));
        $this->assertSame($model, $model->setContinentCode(self::EXAMPLE['continent_code']));
        $this->assertSame($model, $model->setContinentName(self::EXAMPLE['continent_name']));
        $this->assertSame($model, $model->setSubdivisions([]));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Geolocation(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Geolocation::class);

        $this->assertEquals($model->getLatitude(), $deserialized->getLatitude());
        $this->assertEquals($model->getLongitude(), $deserialized->getLongitude());
        $this->assertEquals($model->getCityName(), $deserialized->getCityName());
        $this->assertEquals($model->getCountryCode(), $deserialized->getCountryCode());
        $this->assertEquals($model->getTimezone(), $deserialized->getTimezone());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Geolocation();

        $model['city_name'] = self::EXAMPLE['city_name'];
        $this->assertEquals(self::EXAMPLE['city_name'], $model['city_name']);
        $this->assertTrue(isset($model['city_name']));

        unset($model['city_name']);
        $this->assertNull($model['city_name']);
    }

    /**
     * An empty model should be valid since Geolocation has no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new Geolocation();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $populatedModel = new Geolocation(self::EXAMPLE);
        $this->assertTrue($populatedModel->valid());
        $this->assertEmpty($populatedModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Geolocation(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['city_name'], $decoded['city_name']);
        $this->assertEquals(self::EXAMPLE['country_code'], $decoded['country_code']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Geolocation();

        $this->assertEquals('Geolocation', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Geolocation();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Geolocation(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['city_name'], $serialized->city_name);
        $this->assertEquals(self::EXAMPLE['latitude'], $serialized->latitude);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new Geolocation(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['city_name'], $decoded['city_name']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new Geolocation(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('latitude'));
        $this->assertFalse($model->isNullableSetToNull('city_name'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['city_name'] = null;

        $model = new Geolocation($data);

        $this->assertNull($model->getCityName());
        $this->assertFalse($model->isNullableSetToNull('city_name'));
    }
}
