<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\WebGlBasics;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(WebGlBasics::class)]
class WebGlBasicsTest extends TestCase
{
    private const EXAMPLE = [
        'version' => 'WebGL 2.0',
        'vendor' => 'Google Inc.',
        'renderer' => 'ANGLE',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new WebGlBasics();

        $this->assertNull($model->getVersion());
        $this->assertNull($model->getVendor());
        $this->assertNull($model->getVendorUnmasked());
        $this->assertNull($model->getRenderer());
        $this->assertNull($model->getRendererUnmasked());
        $this->assertNull($model->getShadingLanguageVersion());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new WebGlBasics(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['version'], $model->getVersion());
        $this->assertEquals(self::EXAMPLE['vendor'], $model->getVendor());
        $this->assertEquals(self::EXAMPLE['renderer'], $model->getRenderer());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new WebGlBasics();

        $this->assertSame($model, $model->setVersion(self::EXAMPLE['version']));
        $this->assertSame($model, $model->setVendor(self::EXAMPLE['vendor']));
        $this->assertSame($model, $model->setVendorUnmasked('unmasked'));
        $this->assertSame($model, $model->setRenderer(self::EXAMPLE['renderer']));
        $this->assertSame($model, $model->setRendererUnmasked('unmasked'));
        $this->assertSame($model, $model->setShadingLanguageVersion('GLSL ES 3.00'));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new WebGlBasics(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), WebGlBasics::class);

        $this->assertEquals($model->getVersion(), $deserialized->getVersion());
        $this->assertEquals($model->getVendor(), $deserialized->getVendor());
        $this->assertEquals($model->getRenderer(), $deserialized->getRenderer());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new WebGlBasics();

        $model['version'] = self::EXAMPLE['version'];
        $this->assertEquals(self::EXAMPLE['version'], $model['version']);
        $this->assertTrue(isset($model['version']));

        unset($model['version']);
        $this->assertNull($model['version']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new WebGlBasics();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new WebGlBasics(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['version'], $decoded['version']);
        $this->assertEquals(self::EXAMPLE['vendor'], $decoded['vendor']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new WebGlBasics();

        $this->assertEquals('WebGlBasics', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new WebGlBasics();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new WebGlBasics(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['version'], $serialized->version);
        $this->assertEquals(self::EXAMPLE['vendor'], $serialized->vendor);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new WebGlBasics(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['version'], $decoded['version']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
