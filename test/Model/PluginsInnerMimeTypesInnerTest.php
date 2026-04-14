<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\PluginsInnerMimeTypesInner;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(PluginsInnerMimeTypesInner::class)]
class PluginsInnerMimeTypesInnerTest extends TestCase
{
    private const EXAMPLE = [
        'type' => 'application/pdf',
        'suffixes' => 'pdf',
        'description' => 'PDF',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new PluginsInnerMimeTypesInner();

        $this->assertNull($model->getType());
        $this->assertNull($model->getSuffixes());
        $this->assertNull($model->getDescription());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new PluginsInnerMimeTypesInner(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['type'], $model->getType());
        $this->assertEquals(self::EXAMPLE['suffixes'], $model->getSuffixes());
        $this->assertEquals(self::EXAMPLE['description'], $model->getDescription());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new PluginsInnerMimeTypesInner();

        $this->assertSame($model, $model->setType(self::EXAMPLE['type']));
        $this->assertSame($model, $model->setSuffixes(self::EXAMPLE['suffixes']));
        $this->assertSame($model, $model->setDescription(self::EXAMPLE['description']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new PluginsInnerMimeTypesInner(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), PluginsInnerMimeTypesInner::class);

        $this->assertEquals($model->getType(), $deserialized->getType());
        $this->assertEquals($model->getSuffixes(), $deserialized->getSuffixes());
        $this->assertEquals($model->getDescription(), $deserialized->getDescription());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new PluginsInnerMimeTypesInner();

        $model['type'] = self::EXAMPLE['type'];
        $this->assertEquals(self::EXAMPLE['type'], $model['type']);
        $this->assertTrue(isset($model['type']));

        unset($model['type']);
        $this->assertNull($model['type']);
    }

    /**
     * PluginsInnerMimeTypesInner has no required properties so an empty model should always be valid.
     */
    public function testValidation(): void
    {
        $emptyModel = new PluginsInnerMimeTypesInner();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $validModel = new PluginsInnerMimeTypesInner(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new PluginsInnerMimeTypesInner(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['type'], $decoded['type']);
        $this->assertEquals(self::EXAMPLE['suffixes'], $decoded['suffixes']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new PluginsInnerMimeTypesInner();

        $this->assertEquals('Plugins_inner_mimeTypes_inner', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new PluginsInnerMimeTypesInner();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new PluginsInnerMimeTypesInner(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['type'], $serialized->type);
        $this->assertEquals(self::EXAMPLE['suffixes'], $serialized->suffixes);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new PluginsInnerMimeTypesInner(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['type'], $decoded['type']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
