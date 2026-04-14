<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Integration;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Integration::class)]
class IntegrationTest extends TestCase
{
    private const EXAMPLE = [
        'name' => 'fingerprint-pro',
        'version' => '1.0.0',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Integration();

        $this->assertNull($model->getName());
        $this->assertNull($model->getVersion());
        $this->assertNull($model->getSubintegration());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Integration(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['name'], $model->getName());
        $this->assertEquals(self::EXAMPLE['version'], $model->getVersion());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Integration();

        $this->assertSame($model, $model->setName(self::EXAMPLE['name']));
        $this->assertSame($model, $model->setVersion(self::EXAMPLE['version']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Integration(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Integration::class);

        $this->assertEquals($model->getName(), $deserialized->getName());
        $this->assertEquals($model->getVersion(), $deserialized->getVersion());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Integration();

        $model['name'] = self::EXAMPLE['name'];
        $this->assertEquals(self::EXAMPLE['name'], $model['name']);
        $this->assertTrue(isset($model['name']));

        unset($model['name']);
        $this->assertNull($model['name']);
    }

    /**
     * Integration has no required properties so an empty model should always be valid.
     */
    public function testValidation(): void
    {
        $emptyModel = new Integration();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $validModel = new Integration(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Integration(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
        $this->assertEquals(self::EXAMPLE['version'], $decoded['version']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Integration();

        $this->assertEquals('Integration', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Integration();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Integration(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['name'], $serialized->name);
        $this->assertEquals(self::EXAMPLE['version'], $serialized->version);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new Integration(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['name'], $decoded['name']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
