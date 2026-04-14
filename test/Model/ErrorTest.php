<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Error;
use Fingerprint\ServerSdk\Model\ErrorCode;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Error::class)]
class ErrorTest extends TestCase
{
    private const EXAMPLE = [
        'code' => ErrorCode::VISITOR_NOT_FOUND,
        'message' => 'Visitor not found',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Error();

        $this->assertNull($model->getCode());
        $this->assertNull($model->getMessage());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Error(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['code'], $model->getCode());
        $this->assertEquals(self::EXAMPLE['message'], $model->getMessage());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Error();

        $this->assertSame($model, $model->setCode(self::EXAMPLE['code']));
        $this->assertSame($model, $model->setMessage(self::EXAMPLE['message']));
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Error(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Error::class);

        $this->assertEquals($model->getCode(), $deserialized->getCode());
        $this->assertEquals($model->getMessage(), $deserialized->getMessage());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Error();

        $model['message'] = self::EXAMPLE['message'];
        $this->assertEquals(self::EXAMPLE['message'], $model['message']);
        $this->assertTrue(isset($model['message']));

        unset($model['message']);
        $this->assertNull($model['message']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new Error();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new Error(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Error(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['code']->value, $decoded['code']);
        $this->assertEquals(self::EXAMPLE['message'], $decoded['message']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new Error(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('code'));
        $this->assertFalse($model->isNullableSetToNull('message'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Error();

        $this->assertEquals('Error', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Error();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Error(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['code']->value, $serialized->code);
        $this->assertEquals(self::EXAMPLE['message'], $serialized->message);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new Error(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['code']->value, $decoded['code']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['message'] = null;

        $model = new Error($data);

        $this->assertNull($model->getMessage());
        $this->assertFalse($model->isNullableSetToNull('message'));
    }
}
