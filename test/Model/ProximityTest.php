<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Proximity;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Proximity::class)]
class ProximityTest extends TestCase
{
    private const EXAMPLE = [
        'id' => 'prox-123',
        'precision_radius' => Proximity::PRECISION_RADIUS_NUMBER_10,
        'confidence' => 0.95,
    ];

    private const PRECISION_RADIUS_VALUES = [
        10,
        25,
        65,
        175,
        450,
        1200,
        3300,
        8500,
        22500,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Proximity();

        $this->assertNull($model->getId());
        $this->assertNull($model->getPrecisionRadius());
        $this->assertNull($model->getConfidence());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Proximity(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['id'], $model->getId());
        $this->assertEquals(self::EXAMPLE['precision_radius'], $model->getPrecisionRadius());
        $this->assertEquals(self::EXAMPLE['confidence'], $model->getConfidence());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Proximity();

        $this->assertSame($model, $model->setId(self::EXAMPLE['id']));
        $this->assertSame($model, $model->setPrecisionRadius(self::EXAMPLE['precision_radius']));
        $this->assertSame($model, $model->setConfidence(self::EXAMPLE['confidence']));
    }

    /**
     * setPrecisionRadius should throw InvalidArgumentException for an invalid enum value.
     */
    public function testSetPrecisionRadiusRejectsInvalidValue(): void
    {
        $model = new Proximity();

        $this->expectException(\InvalidArgumentException::class);
        $model->setPrecisionRadius(999);
    }

    /**
     * getPrecisionRadiusAllowableValues should return all defined precision_radius constants.
     */
    public function testPrecisionRadiusAllowableValues(): void
    {
        $model = new Proximity();
        $allowable = $model->getPrecisionRadiusAllowableValues();

        foreach (self::PRECISION_RADIUS_VALUES as $value) {
            $this->assertContains($value, $allowable);
        }
        $this->assertCount(count(self::PRECISION_RADIUS_VALUES), $allowable);
    }

    /**
     * setConfidence should throw InvalidArgumentException when value exceeds 1.
     */
    public function testSetConfidenceRejectsValueAboveOne(): void
    {
        $model = new Proximity();

        $this->expectException(\InvalidArgumentException::class);
        $model->setConfidence(1.5);
    }

    /**
     * setConfidence should throw InvalidArgumentException when value is below 0.
     */
    public function testSetConfidenceRejectsValueBelowZero(): void
    {
        $model = new Proximity();

        $this->expectException(\InvalidArgumentException::class);
        $model->setConfidence(-0.1);
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Proximity(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Proximity::class);

        $this->assertEquals($model->getId(), $deserialized->getId());
        $this->assertEquals($model->getPrecisionRadius(), $deserialized->getPrecisionRadius());
        $this->assertEquals($model->getConfidence(), $deserialized->getConfidence());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Proximity();

        $model['id'] = 'prox-456';
        $this->assertEquals('prox-456', $model['id']);
        $this->assertTrue(isset($model['id']));

        unset($model['id']);
        $this->assertNull($model['id']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new Proximity();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new Proximity(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Proximity(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['id'], $decoded['id']);
        $this->assertEquals(self::EXAMPLE['precision_radius'], $decoded['precision_radius']);
        $this->assertEquals(self::EXAMPLE['confidence'], $decoded['confidence']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new Proximity(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('id'));
        $this->assertFalse($model->isNullableSetToNull('precision_radius'));
        $this->assertFalse($model->isNullableSetToNull('confidence'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Proximity();

        $this->assertEquals('Proximity', $model->getModelName());
    }

    /**
     * listInvalidProperties should report invalid enum values set via ArrayAccess bypass.
     */
    public function testListInvalidPropertiesWithInvalidEnumValues(): void
    {
        $model = new Proximity(self::EXAMPLE);

        $model['precision_radius'] = 999;

        $invalid = $model->listInvalidProperties();
        $expected = "'".implode("', '", self::PRECISION_RADIUS_VALUES)."'";

        $this->assertContains(
            "invalid value '999' for 'precision_radius', must be one of ".$expected,
            $invalid
        );
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Proximity();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Proximity(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['id'], $serialized->id);
        $this->assertEquals(self::EXAMPLE['precision_radius'], $serialized->precision_radius);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new Proximity(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['id'], $decoded['id']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['id'] = null;

        $model = new Proximity($data);

        $this->assertNull($model->getId());
        $this->assertFalse($model->isNullableSetToNull('id'));
    }
}
