<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Emoji;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Emoji::class)]
class EmojiTest extends TestCase
{
    private const EXAMPLE = [
        'font' => 'Arial',
        'width' => 16.0,
        'height' => 18.0,
        'top' => 0.0,
        'bottom' => 18.0,
        'left' => 0.0,
        'right' => 16.0,
        'x' => 8.0,
        'y' => 9.0,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Emoji();

        $this->assertNull($model->getFont());
        $this->assertNull($model->getWidth());
        $this->assertNull($model->getHeight());
        $this->assertNull($model->getTop());
        $this->assertNull($model->getBottom());
        $this->assertNull($model->getLeft());
        $this->assertNull($model->getRight());
        $this->assertNull($model->getX());
        $this->assertNull($model->getY());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new Emoji(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['font'], $model->getFont());
        $this->assertEquals(self::EXAMPLE['width'], $model->getWidth());
        $this->assertEquals(self::EXAMPLE['height'], $model->getHeight());
        $this->assertEquals(self::EXAMPLE['top'], $model->getTop());
        $this->assertEquals(self::EXAMPLE['bottom'], $model->getBottom());
        $this->assertEquals(self::EXAMPLE['left'], $model->getLeft());
        $this->assertEquals(self::EXAMPLE['right'], $model->getRight());
        $this->assertEquals(self::EXAMPLE['x'], $model->getX());
        $this->assertEquals(self::EXAMPLE['y'], $model->getY());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new Emoji();

        $this->assertSame($model, $model->setFont(self::EXAMPLE['font']));
        $this->assertSame($model, $model->setWidth(self::EXAMPLE['width']));
        $this->assertSame($model, $model->setHeight(self::EXAMPLE['height']));
        $this->assertSame($model, $model->setTop(self::EXAMPLE['top']));
        $this->assertSame($model, $model->setBottom(self::EXAMPLE['bottom']));
        $this->assertSame($model, $model->setLeft(self::EXAMPLE['left']));
        $this->assertSame($model, $model->setRight(self::EXAMPLE['right']));
        $this->assertSame($model, $model->setX(self::EXAMPLE['x']));
        $this->assertSame($model, $model->setY(self::EXAMPLE['y']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new Emoji(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), Emoji::class);

        $this->assertEquals($model->getFont(), $deserialized->getFont());
        $this->assertEquals($model->getWidth(), $deserialized->getWidth());
        $this->assertEquals($model->getHeight(), $deserialized->getHeight());
        $this->assertEquals($model->getTop(), $deserialized->getTop());
        $this->assertEquals($model->getBottom(), $deserialized->getBottom());
        $this->assertEquals($model->getLeft(), $deserialized->getLeft());
        $this->assertEquals($model->getRight(), $deserialized->getRight());
        $this->assertEquals($model->getX(), $deserialized->getX());
        $this->assertEquals($model->getY(), $deserialized->getY());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Emoji();

        $model['font'] = self::EXAMPLE['font'];
        $this->assertEquals(self::EXAMPLE['font'], $model['font']);
        $this->assertTrue(isset($model['font']));

        unset($model['font']);
        $this->assertNull($model['font']);
    }

    /**
     * Emoji has no required properties so an empty model should always be valid.
     */
    public function testValidation(): void
    {
        $emptyModel = new Emoji();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $validModel = new Emoji(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new Emoji(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['font'], $decoded['font']);
        $this->assertEquals(self::EXAMPLE['width'], $decoded['width']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Emoji();

        $this->assertEquals('Emoji', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Emoji();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Emoji(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['font'], $serialized->font);
        $this->assertEquals(self::EXAMPLE['width'], $serialized->width);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new Emoji(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['font'], $decoded['font']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
