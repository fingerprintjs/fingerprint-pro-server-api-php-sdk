<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\VelocityData;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(VelocityData::class)]
class VelocityDataTest extends TestCase
{
    private const EXAMPLE = [
        '_5_minutes' => 10,
        '_1_hour' => 50,
        '_24_hours' => 200,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new VelocityData();

        $this->assertNull($model->get5Minutes());
        $this->assertNull($model->get1Hour());
        $this->assertNull($model->get24Hours());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new VelocityData(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['_5_minutes'], $model->get5Minutes());
        $this->assertEquals(self::EXAMPLE['_1_hour'], $model->get1Hour());
        $this->assertEquals(self::EXAMPLE['_24_hours'], $model->get24Hours());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new VelocityData();

        $this->assertSame($model, $model->set5Minutes(self::EXAMPLE['_5_minutes']));
        $this->assertSame($model, $model->set1Hour(self::EXAMPLE['_1_hour']));
        $this->assertSame($model, $model->set24Hours(self::EXAMPLE['_24_hours']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new VelocityData(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), VelocityData::class);

        $this->assertEquals($model->get5Minutes(), $deserialized->get5Minutes());
        $this->assertEquals($model->get1Hour(), $deserialized->get1Hour());
        $this->assertEquals($model->get24Hours(), $deserialized->get24Hours());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new VelocityData();

        $model['_5_minutes'] = self::EXAMPLE['_5_minutes'];
        $this->assertEquals(self::EXAMPLE['_5_minutes'], $model['_5_minutes']);
        $this->assertTrue(isset($model['_5_minutes']));

        unset($model['_5_minutes']);
        $this->assertNull($model['_5_minutes']);
    }

    /**
     * A default-constructed model should be invalid because _5_minutes and _1_hour are required.
     */
    public function testValidation(): void
    {
        $emptyModel = new VelocityData();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new VelocityData(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new VelocityData(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['_5_minutes'], $decoded['5_minutes']);
        $this->assertEquals(self::EXAMPLE['_1_hour'], $decoded['1_hour']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new VelocityData();

        $this->assertEquals('VelocityData', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new VelocityData();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new VelocityData(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new VelocityData(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertStringNotContainsString("\n", $header);
    }
}
