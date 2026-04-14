<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\WebGlExtensions;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(WebGlExtensions::class)]
class WebGlExtensionsTest extends TestCase
{
    private const EXAMPLE = [
        'context_attributes' => 'attrs',
        'parameters' => 'params',
        'extensions' => 'ext',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new WebGlExtensions();

        $this->assertNull($model->getContextAttributes());
        $this->assertNull($model->getParameters());
        $this->assertNull($model->getShaderPrecisions());
        $this->assertNull($model->getExtensions());
        $this->assertNull($model->getExtensionParameters());
        $this->assertNull($model->getUnsupportedExtensions());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new WebGlExtensions(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['context_attributes'], $model->getContextAttributes());
        $this->assertEquals(self::EXAMPLE['parameters'], $model->getParameters());
        $this->assertEquals(self::EXAMPLE['extensions'], $model->getExtensions());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new WebGlExtensions();

        $this->assertSame($model, $model->setContextAttributes(self::EXAMPLE['context_attributes']));
        $this->assertSame($model, $model->setParameters(self::EXAMPLE['parameters']));
        $this->assertSame($model, $model->setShaderPrecisions('precisions'));
        $this->assertSame($model, $model->setExtensions(self::EXAMPLE['extensions']));
        $this->assertSame($model, $model->setExtensionParameters('ext_params'));
        $this->assertSame($model, $model->setUnsupportedExtensions(['ext1', 'ext2']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new WebGlExtensions(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), WebGlExtensions::class);

        $this->assertEquals($model->getContextAttributes(), $deserialized->getContextAttributes());
        $this->assertEquals($model->getParameters(), $deserialized->getParameters());
        $this->assertEquals($model->getExtensions(), $deserialized->getExtensions());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new WebGlExtensions();

        $model['context_attributes'] = self::EXAMPLE['context_attributes'];
        $this->assertEquals(self::EXAMPLE['context_attributes'], $model['context_attributes']);
        $this->assertTrue(isset($model['context_attributes']));

        unset($model['context_attributes']);
        $this->assertNull($model['context_attributes']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new WebGlExtensions();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new WebGlExtensions(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['context_attributes'], $decoded['context_attributes']);
        $this->assertEquals(self::EXAMPLE['parameters'], $decoded['parameters']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new WebGlExtensions();

        $this->assertEquals('WebGlExtensions', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new WebGlExtensions();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new WebGlExtensions(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['context_attributes'], $serialized->context_attributes);
        $this->assertEquals(self::EXAMPLE['parameters'], $serialized->parameters);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new WebGlExtensions(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['context_attributes'], $decoded['context_attributes']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
