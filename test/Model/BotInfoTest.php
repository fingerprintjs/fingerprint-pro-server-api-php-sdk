<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\BotInfo;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(BotInfo::class)]
class BotInfoTest extends TestCase
{
    private const EXAMPLE = [
        'category' => 'search_engine_crawler',
        'provider' => 'Google',
        'provider_url' => 'https://google.com',
        'name' => 'Googlebot',
        'identity' => BotInfo::IDENTITY_VERIFIED,
        'confidence' => BotInfo::CONFIDENCE_HIGH,
    ];

    private const IDENTITY_VALUES = [
        'verified',
        'signed',
        'spoofed',
        'unknown',
    ];

    private const CONFIDENCE_VALUES = [
        'low',
        'medium',
        'high',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new BotInfo();

        $this->assertNull($model->getCategory());
        $this->assertNull($model->getProvider());
        $this->assertNull($model->getProviderUrl());
        $this->assertNull($model->getName());
        $this->assertNull($model->getIdentity());
        $this->assertNull($model->getConfidence());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new BotInfo(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['category'], $model->getCategory());
        $this->assertEquals(self::EXAMPLE['provider'], $model->getProvider());
        $this->assertEquals(self::EXAMPLE['provider_url'], $model->getProviderUrl());
        $this->assertEquals(self::EXAMPLE['name'], $model->getName());
        $this->assertEquals(self::EXAMPLE['identity'], $model->getIdentity());
        $this->assertEquals(self::EXAMPLE['confidence'], $model->getConfidence());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new BotInfo();

        $this->assertSame($model, $model->setCategory(self::EXAMPLE['category']));
        $this->assertSame($model, $model->setProvider(self::EXAMPLE['provider']));
        $this->assertSame($model, $model->setProviderUrl(self::EXAMPLE['provider_url']));
        $this->assertSame($model, $model->setName(self::EXAMPLE['name']));
        $this->assertSame($model, $model->setIdentity(self::EXAMPLE['identity']));
        $this->assertSame($model, $model->setConfidence(self::EXAMPLE['confidence']));
    }

    /**
     * setIdentity should throw InvalidArgumentException for an invalid enum value.
     */
    public function testSetIdentityRejectsInvalidValue(): void
    {
        $model = new BotInfo();

        $this->expectException(\InvalidArgumentException::class);
        $model->setIdentity('invalid');
    }

    /**
     * setConfidence should throw InvalidArgumentException for an invalid enum value.
     */
    public function testSetConfidenceRejectsInvalidValue(): void
    {
        $model = new BotInfo();

        $this->expectException(\InvalidArgumentException::class);
        $model->setConfidence('invalid');
    }

    /**
     * getIdentityAllowableValues should return all defined identity constants.
     */
    public function testIdentityAllowableValues(): void
    {
        $model = new BotInfo();
        $allowable = $model->getIdentityAllowableValues();

        foreach (self::IDENTITY_VALUES as $value) {
            $this->assertContains($value, $allowable);
        }
        $this->assertCount(count(self::IDENTITY_VALUES), $allowable);
    }

    /**
     * getConfidenceAllowableValues should return all defined confidence constants.
     */
    public function testConfidenceAllowableValues(): void
    {
        $model = new BotInfo();
        $allowable = $model->getConfidenceAllowableValues();

        foreach (self::CONFIDENCE_VALUES as $value) {
            $this->assertContains($value, $allowable);
        }
        $this->assertCount(count(self::CONFIDENCE_VALUES), $allowable);
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new BotInfo(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), BotInfo::class);

        $this->assertEquals($model->getCategory(), $deserialized->getCategory());
        $this->assertEquals($model->getProvider(), $deserialized->getProvider());
        $this->assertEquals($model->getProviderUrl(), $deserialized->getProviderUrl());
        $this->assertEquals($model->getName(), $deserialized->getName());
        $this->assertEquals($model->getIdentity(), $deserialized->getIdentity());
        $this->assertEquals($model->getConfidence(), $deserialized->getConfidence());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new BotInfo();

        $model['category'] = self::EXAMPLE['category'];
        $this->assertEquals(self::EXAMPLE['category'], $model['category']);
        $this->assertTrue(isset($model['category']));

        unset($model['category']);
        $this->assertNull($model['category']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new BotInfo();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new BotInfo(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new BotInfo(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['category'], $decoded['category']);
        $this->assertEquals(self::EXAMPLE['provider'], $decoded['provider']);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new BotInfo(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('category'));
        $this->assertFalse($model->isNullableSetToNull('provider'));
        $this->assertFalse($model->isNullableSetToNull('identity'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new BotInfo();

        $this->assertEquals('BotInfo', $model->getModelName());
    }

    /**
     * listInvalidProperties should report invalid enum values set via ArrayAccess bypass.
     */
    public function testListInvalidPropertiesWithInvalidEnumValues(): void
    {
        $model = new BotInfo(self::EXAMPLE);

        $model['identity'] = 'not_a_valid_identity';
        $model['confidence'] = 'not_a_valid_confidence';

        $invalid = $model->listInvalidProperties();
        $expected = "'".implode("', '", self::IDENTITY_VALUES)."'";

        $this->assertContains(
            "invalid value 'not_a_valid_identity' for 'identity', must be one of ".$expected,
            $invalid
        );

        $expected = "'".implode("', '", self::CONFIDENCE_VALUES)."'";
        $this->assertContains(
            "invalid value 'not_a_valid_confidence' for 'confidence', must be one of ".$expected,
            $invalid
        );
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new BotInfo();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new BotInfo(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['category'], $serialized->category);
        $this->assertEquals(self::EXAMPLE['name'], $serialized->name);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new BotInfo(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['category'], $decoded['category']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['category'] = null;

        $model = new BotInfo($data);

        $this->assertNull($model->getCategory());
        $this->assertFalse($model->isNullableSetToNull('category'));
    }
}
