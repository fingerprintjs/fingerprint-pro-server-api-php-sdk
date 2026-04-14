<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\TouchSupport;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(TouchSupport::class)]
class TouchSupportTest extends TestCase
{
    private const EXAMPLE = [
        'touch_event' => true,
        'touch_start' => true,
        'max_touch_points' => 5,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new TouchSupport();

        $this->assertNull($model->getTouchEvent());
        $this->assertNull($model->getTouchStart());
        $this->assertNull($model->getMaxTouchPoints());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new TouchSupport(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['touch_event'], $model->getTouchEvent());
        $this->assertEquals(self::EXAMPLE['touch_start'], $model->getTouchStart());
        $this->assertEquals(self::EXAMPLE['max_touch_points'], $model->getMaxTouchPoints());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new TouchSupport();

        $this->assertSame($model, $model->setTouchEvent(self::EXAMPLE['touch_event']));
        $this->assertSame($model, $model->setTouchStart(self::EXAMPLE['touch_start']));
        $this->assertSame($model, $model->setMaxTouchPoints(self::EXAMPLE['max_touch_points']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new TouchSupport(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), TouchSupport::class);

        $this->assertEquals($model->getTouchEvent(), $deserialized->getTouchEvent());
        $this->assertEquals($model->getTouchStart(), $deserialized->getTouchStart());
        $this->assertEquals($model->getMaxTouchPoints(), $deserialized->getMaxTouchPoints());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new TouchSupport();

        $model['touch_event'] = self::EXAMPLE['touch_event'];
        $this->assertEquals(self::EXAMPLE['touch_event'], $model['touch_event']);
        $this->assertTrue(isset($model['touch_event']));

        unset($model['touch_event']);
        $this->assertNull($model['touch_event']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new TouchSupport();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new TouchSupport(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['touch_event'], $decoded['touch_event']);
        $this->assertEquals(self::EXAMPLE['max_touch_points'], $decoded['max_touch_points']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new TouchSupport();

        $this->assertEquals('TouchSupport', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new TouchSupport();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new TouchSupport(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['touch_event'], $serialized->touch_event);
        $this->assertEquals(self::EXAMPLE['max_touch_points'], $serialized->max_touch_points);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new TouchSupport(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['touch_event'], $decoded['touch_event']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
