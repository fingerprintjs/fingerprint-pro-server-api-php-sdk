<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\SDK;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(SDK::class)]
class SDKTest extends TestCase
{
    private const EXAMPLE = [
        'platform' => SDK::PLATFORM_JS,
        'version' => '3.0.0',
    ];

    private const PLATFORM_VALUES = [
        'js',
        'android',
        'ios',
        'unknown',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new SDK();

        $this->assertNull($model->getPlatform());
        $this->assertNull($model->getVersion());
        $this->assertNull($model->getIntegrations());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new SDK(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['platform'], $model->getPlatform());
        $this->assertEquals(self::EXAMPLE['version'], $model->getVersion());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new SDK();

        $this->assertSame($model, $model->setPlatform(self::EXAMPLE['platform']));
        $this->assertSame($model, $model->setVersion(self::EXAMPLE['version']));
        $this->assertSame($model, $model->setIntegrations([]));
    }

    /**
     * setPlatform should throw InvalidArgumentException for an invalid enum value.
     */
    public function testSetPlatformRejectsInvalidValue(): void
    {
        $model = new SDK();

        $this->expectException(\InvalidArgumentException::class);
        $model->setPlatform('invalid');
    }

    /**
     * getPlatformAllowableValues should return all defined platform constants.
     */
    public function testPlatformAllowableValues(): void
    {
        $model = new SDK();
        $allowable = $model->getPlatformAllowableValues();

        foreach (self::PLATFORM_VALUES as $value) {
            $this->assertContains($value, $allowable);
        }
        $this->assertCount(count(self::PLATFORM_VALUES), $allowable);
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new SDK(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), SDK::class);

        $this->assertEquals($model->getPlatform(), $deserialized->getPlatform());
        $this->assertEquals($model->getVersion(), $deserialized->getVersion());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new SDK();

        $model['platform'] = SDK::PLATFORM_ANDROID;
        $this->assertEquals(SDK::PLATFORM_ANDROID, $model['platform']);
        $this->assertTrue(isset($model['platform']));

        unset($model['platform']);
        $this->assertNull($model['platform']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new SDK();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new SDK(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new SDK(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['platform'], $decoded['platform']);
        $this->assertEquals(self::EXAMPLE['version'], $decoded['version']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new SDK(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('platform'));
        $this->assertFalse($model->isNullableSetToNull('version'));
        $this->assertFalse($model->isNullableSetToNull('integrations'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new SDK();

        $this->assertEquals('SDK', $model->getModelName());
    }

    /**
     * listInvalidProperties should report invalid enum values set via ArrayAccess bypass.
     */
    public function testListInvalidPropertiesWithInvalidEnumValues(): void
    {
        $model = new SDK(self::EXAMPLE);

        $model['platform'] = 'not_a_valid_platform';

        $invalid = $model->listInvalidProperties();
        $expected = "'".implode("', '", self::PLATFORM_VALUES)."'";

        $this->assertContains(
            "invalid value 'not_a_valid_platform' for 'platform', must be one of ".$expected,
            $invalid
        );
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new SDK();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new SDK(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['platform'], $serialized->platform);
        $this->assertEquals(self::EXAMPLE['version'], $serialized->version);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new SDK(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['platform'], $decoded['platform']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['platform'] = null;

        $model = new SDK($data);

        $this->assertNull($model->getPlatform());
        $this->assertFalse($model->isNullableSetToNull('platform'));
    }
}
