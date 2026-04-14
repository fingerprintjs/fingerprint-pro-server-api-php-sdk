<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Canvas;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Canvas::class)]
class CanvasTest extends TestCase
{
    private const EXAMPLE = [
        'winding' => true,
        'geometry' => 'hash123',
        'text' => 'hash456',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Canvas();

        $this->assertNull($model->getWinding());
        $this->assertNull($model->getGeometry());
        $this->assertNull($model->getText());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Canvas(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['winding'], $model->getWinding());
        $this->assertEquals(self::EXAMPLE['geometry'], $model->getGeometry());
        $this->assertEquals(self::EXAMPLE['text'], $model->getText());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Canvas();

        $this->assertSame($model, $model->setWinding(self::EXAMPLE['winding']));
        $this->assertSame($model, $model->setGeometry(self::EXAMPLE['geometry']));
        $this->assertSame($model, $model->setText(self::EXAMPLE['text']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Canvas(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Canvas::class);

        $this->assertEquals($model->getWinding(), $deserialized->getWinding());
        $this->assertEquals($model->getGeometry(), $deserialized->getGeometry());
        $this->assertEquals($model->getText(), $deserialized->getText());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Canvas();

        $model['winding'] = self::EXAMPLE['winding'];
        $this->assertEquals(self::EXAMPLE['winding'], $model['winding']);
        $this->assertTrue(isset($model['winding']));

        unset($model['winding']);
        $this->assertNull($model['winding']);
    }

    /**
     * Canvas has no required properties so an empty model should always be valid.
     */
    public function testValidation(): void
    {
        $emptyModel = new Canvas();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $validModel = new Canvas(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Canvas(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['winding'], $decoded['winding']);
        $this->assertEquals(self::EXAMPLE['geometry'], $decoded['geometry']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Canvas();

        $this->assertEquals('Canvas', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Canvas();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Canvas(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['winding'], $serialized->winding);
        $this->assertEquals(self::EXAMPLE['geometry'], $serialized->geometry);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new Canvas(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['winding'], $decoded['winding']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
