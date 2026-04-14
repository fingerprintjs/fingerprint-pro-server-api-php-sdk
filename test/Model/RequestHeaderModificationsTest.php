<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\RequestHeaderModifications;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(RequestHeaderModifications::class)]
class RequestHeaderModificationsTest extends TestCase
{
    private const EXAMPLE = [
        'remove' => ['X-Old-Header'],
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new RequestHeaderModifications();

        $this->assertNull($model->getRemove());
        $this->assertNull($model->getSet());
        $this->assertNull($model->getAppend());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new RequestHeaderModifications(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['remove'], $model->getRemove());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new RequestHeaderModifications();

        $this->assertSame($model, $model->setRemove(self::EXAMPLE['remove']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new RequestHeaderModifications(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), RequestHeaderModifications::class);

        $this->assertEquals($model->getRemove(), $deserialized->getRemove());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new RequestHeaderModifications();

        $model['remove'] = self::EXAMPLE['remove'];
        $this->assertEquals(self::EXAMPLE['remove'], $model['remove']);
        $this->assertTrue(isset($model['remove']));

        unset($model['remove']);
        $this->assertNull($model['remove']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new RequestHeaderModifications();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new RequestHeaderModifications(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['remove'], $decoded['remove']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new RequestHeaderModifications();

        $this->assertEquals('RequestHeaderModifications', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new RequestHeaderModifications();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new RequestHeaderModifications(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['remove'], $serialized->remove);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new RequestHeaderModifications(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['remove'], $decoded['remove']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
