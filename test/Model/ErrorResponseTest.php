<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Error;
use Fingerprint\ServerSdk\Model\ErrorCode;
use Fingerprint\ServerSdk\Model\ErrorResponse;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ErrorResponse::class)]
class ErrorResponseTest extends TestCase
{
    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new ErrorResponse();

        $this->assertNull($model->getError());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $error = self::exampleError();
        $model = new ErrorResponse(['error' => $error]);

        $this->assertSame($error, $model->getError());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new ErrorResponse();

        $this->assertSame($model, $model->setError(self::exampleError()));
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new ErrorResponse(['error' => self::exampleError()]);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), ErrorResponse::class);

        $this->assertEquals($model->getError()->getCode(), $deserialized->getError()->getCode());
        $this->assertEquals($model->getError()->getMessage(), $deserialized->getError()->getMessage());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new ErrorResponse();
        $error = self::exampleError();

        $model['error'] = $error;
        $this->assertSame($error, $model['error']);
        $this->assertTrue(isset($model['error']));

        unset($model['error']);
        $this->assertNull($model['error']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new ErrorResponse();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new ErrorResponse(['error' => self::exampleError()]);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new ErrorResponse(['error' => self::exampleError()]);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertIsArray($decoded['error']);
        $this->assertEquals('visitor_not_found', $decoded['error']['code']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new ErrorResponse(['error' => self::exampleError()]);

        $this->assertFalse($model->isNullableSetToNull('error'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new ErrorResponse();

        $this->assertEquals('ErrorResponse', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new ErrorResponse();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new ErrorResponse(['error' => self::exampleError()]);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertIsObject($serialized->error);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new ErrorResponse(['error' => self::exampleError()]);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertArrayHasKey('error', $decoded);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $model = new ErrorResponse(['error' => null]);

        $this->assertNull($model->getError());
        $this->assertFalse($model->isNullableSetToNull('error'));
    }

    private static function exampleError(): Error
    {
        return new Error(['code' => ErrorCode::VISITOR_NOT_FOUND, 'message' => 'Not found']);
    }
}
