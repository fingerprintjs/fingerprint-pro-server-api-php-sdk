<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\IdentificationConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(IdentificationConfidence::class)]
class IdentificationConfidenceTest extends TestCase
{
    private const EXAMPLE = [
        'score' => 0.99,
        'version' => '1.0',
        'comment' => 'high confidence',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new IdentificationConfidence();

        $this->assertNull($model->getScore());
        $this->assertNull($model->getVersion());
        $this->assertNull($model->getComment());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new IdentificationConfidence(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['score'], $model->getScore());
        $this->assertEquals(self::EXAMPLE['version'], $model->getVersion());
        $this->assertEquals(self::EXAMPLE['comment'], $model->getComment());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new IdentificationConfidence();

        $this->assertSame($model, $model->setScore(self::EXAMPLE['score']));
        $this->assertSame($model, $model->setVersion(self::EXAMPLE['version']));
        $this->assertSame($model, $model->setComment(self::EXAMPLE['comment']));
    }

    /**
     * setScore should throw InvalidArgumentException when value exceeds 1.
     */
    public function testSetScoreRejectsValueAboveOne(): void
    {
        $model = new IdentificationConfidence();

        $this->expectException(\InvalidArgumentException::class);
        $model->setScore(1.5);
    }

    /**
     * setScore should throw InvalidArgumentException when value is below 0.
     */
    public function testSetScoreRejectsValueBelowZero(): void
    {
        $model = new IdentificationConfidence();

        $this->expectException(\InvalidArgumentException::class);
        $model->setScore(-0.1);
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new IdentificationConfidence(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), IdentificationConfidence::class);

        $this->assertEquals($model->getScore(), $deserialized->getScore());
        $this->assertEquals($model->getVersion(), $deserialized->getVersion());
        $this->assertEquals($model->getComment(), $deserialized->getComment());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new IdentificationConfidence();

        $model['score'] = 0.85;
        $this->assertEquals(0.85, $model['score']);
        $this->assertTrue(isset($model['score']));

        unset($model['score']);
        $this->assertNull($model['score']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new IdentificationConfidence();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new IdentificationConfidence(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new IdentificationConfidence(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['score'], $decoded['score']);
        $this->assertEquals(self::EXAMPLE['version'], $decoded['version']);
        $this->assertEquals(self::EXAMPLE['comment'], $decoded['comment']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new IdentificationConfidence(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('score'));
        $this->assertFalse($model->isNullableSetToNull('version'));
        $this->assertFalse($model->isNullableSetToNull('comment'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new IdentificationConfidence();

        $this->assertEquals('IdentificationConfidence', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new IdentificationConfidence();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new IdentificationConfidence(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['score'], $serialized->score);
        $this->assertEquals(self::EXAMPLE['version'], $serialized->version);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new IdentificationConfidence(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['score'], $decoded['score']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['score'] = null;

        $model = new IdentificationConfidence($data);

        $this->assertNull($model->getScore());
        $this->assertFalse($model->isNullableSetToNull('score'));
    }
}
