<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\PluginsInner;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(PluginsInner::class)]
class PluginsInnerTest extends TestCase
{
    private const EXAMPLE = [
        'name' => 'Chrome PDF Plugin',
        'description' => 'Portable Document Format',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new PluginsInner();

        $this->assertNull($model->getName());
        $this->assertNull($model->getDescription());
        $this->assertNull($model->getMimeTypes());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new PluginsInner(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['name'], $model->getName());
        $this->assertEquals(self::EXAMPLE['description'], $model->getDescription());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new PluginsInner();

        $this->assertSame($model, $model->setName(self::EXAMPLE['name']));
        $this->assertSame($model, $model->setDescription(self::EXAMPLE['description']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new PluginsInner(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), PluginsInner::class);

        $this->assertEquals($model->getName(), $deserialized->getName());
        $this->assertEquals($model->getDescription(), $deserialized->getDescription());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new PluginsInner();

        $model['name'] = self::EXAMPLE['name'];
        $this->assertEquals(self::EXAMPLE['name'], $model['name']);
        $this->assertTrue(isset($model['name']));

        unset($model['name']);
        $this->assertNull($model['name']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not because name is required.
     */
    public function testValidation(): void
    {
        $emptyModel = new PluginsInner();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new PluginsInner(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new PluginsInner(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
        $this->assertEquals(self::EXAMPLE['description'], $decoded['description']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new PluginsInner();

        $this->assertEquals('Plugins_inner', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new PluginsInner();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new PluginsInner(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['name'], $serialized->name);
        $this->assertEquals(self::EXAMPLE['description'], $serialized->description);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new PluginsInner(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
