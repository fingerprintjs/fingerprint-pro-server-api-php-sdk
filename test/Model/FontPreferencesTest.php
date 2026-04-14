<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\FontPreferences;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(FontPreferences::class)]
class FontPreferencesTest extends TestCase
{
    private const EXAMPLE = [
        'default' => 12.0,
        'serif' => 14.0,
        'sans' => 12.0,
        'mono' => 10.0,
        'apple' => 11.0,
        'min' => 8.0,
        'system' => 13.0,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new FontPreferences();

        $this->assertNull($model->getDefault());
        $this->assertNull($model->getSerif());
        $this->assertNull($model->getSans());
        $this->assertNull($model->getMono());
        $this->assertNull($model->getApple());
        $this->assertNull($model->getMin());
        $this->assertNull($model->getSystem());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new FontPreferences(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['default'], $model->getDefault());
        $this->assertEquals(self::EXAMPLE['serif'], $model->getSerif());
        $this->assertEquals(self::EXAMPLE['sans'], $model->getSans());
        $this->assertEquals(self::EXAMPLE['mono'], $model->getMono());
        $this->assertEquals(self::EXAMPLE['apple'], $model->getApple());
        $this->assertEquals(self::EXAMPLE['min'], $model->getMin());
        $this->assertEquals(self::EXAMPLE['system'], $model->getSystem());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new FontPreferences();

        $this->assertSame($model, $model->setDefault(self::EXAMPLE['default']));
        $this->assertSame($model, $model->setSerif(self::EXAMPLE['serif']));
        $this->assertSame($model, $model->setSans(self::EXAMPLE['sans']));
        $this->assertSame($model, $model->setMono(self::EXAMPLE['mono']));
        $this->assertSame($model, $model->setApple(self::EXAMPLE['apple']));
        $this->assertSame($model, $model->setMin(self::EXAMPLE['min']));
        $this->assertSame($model, $model->setSystem(self::EXAMPLE['system']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new FontPreferences(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), FontPreferences::class);

        $this->assertEquals($model->getDefault(), $deserialized->getDefault());
        $this->assertEquals($model->getSerif(), $deserialized->getSerif());
        $this->assertEquals($model->getSans(), $deserialized->getSans());
        $this->assertEquals($model->getMono(), $deserialized->getMono());
        $this->assertEquals($model->getApple(), $deserialized->getApple());
        $this->assertEquals($model->getMin(), $deserialized->getMin());
        $this->assertEquals($model->getSystem(), $deserialized->getSystem());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new FontPreferences();

        $model['default'] = self::EXAMPLE['default'];
        $this->assertEquals(self::EXAMPLE['default'], $model['default']);
        $this->assertTrue(isset($model['default']));

        unset($model['default']);
        $this->assertNull($model['default']);
    }

    /**
     * FontPreferences has no required properties so an empty model should always be valid.
     */
    public function testValidation(): void
    {
        $emptyModel = new FontPreferences();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $validModel = new FontPreferences(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new FontPreferences(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['default'], $decoded['default']);
        $this->assertEquals(self::EXAMPLE['serif'], $decoded['serif']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new FontPreferences();

        $this->assertEquals('FontPreferences', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new FontPreferences();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new FontPreferences(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['default'], $serialized->default);
        $this->assertEquals(self::EXAMPLE['serif'], $serialized->serif);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new FontPreferences(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['default'], $decoded['default']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
