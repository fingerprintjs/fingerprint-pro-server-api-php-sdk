<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\IPInfo;
use Fingerprint\ServerSdk\Model\IPInfoV4;
use Fingerprint\ServerSdk\Model\IPInfoV6;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(IPInfo::class)]
class IPInfoTest extends TestCase
{
    private const EXAMPLE = [
        'v4' => null,
        'v6' => null,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new IPInfo();

        $this->assertNull($model->getV4());
        $this->assertNull($model->getV6());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new IPInfo(self::EXAMPLE);

        $this->assertNull($model->getV4());
        $this->assertNull($model->getV6());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new IPInfo();

        $v4 = new IPInfoV4();
        $v6 = new IPInfoV6();
        $this->assertSame($model, $model->setV4($v4));
        $this->assertSame($model, $model->setV6($v6));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new IPInfo(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), IPInfo::class);

        $this->assertEquals($model->getV4(), $deserialized->getV4());
        $this->assertEquals($model->getV6(), $deserialized->getV6());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new IPInfo();

        $v4 = new IPInfoV4();
        $model['v4'] = $v4;
        $this->assertSame($v4, $model['v4']);
        $this->assertTrue(isset($model['v4']));

        unset($model['v4']);
        $this->assertNull($model['v4']);
    }

    /**
     * An empty model should be valid since IPInfo has no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new IPInfo();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $populatedModel = new IPInfo(self::EXAMPLE);
        $this->assertTrue($populatedModel->valid());
        $this->assertEmpty($populatedModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new IPInfo(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertIsArray($decoded);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new IPInfo();

        $this->assertEquals('IPInfo', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new IPInfo();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new IPInfo(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new IPInfo(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new IPInfo(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('v4'));
        $this->assertFalse($model->isNullableSetToNull('v6'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['v4'] = null;

        $model = new IPInfo($data);

        $this->assertNull($model->getV4());
        $this->assertFalse($model->isNullableSetToNull('v4'));
    }
}
