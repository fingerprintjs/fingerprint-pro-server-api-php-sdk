<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\TamperingDetails;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(TamperingDetails::class)]
class TamperingDetailsTest extends TestCase
{
    private const EXAMPLE = [
        'anomaly_score' => 0.5,
        'anti_detect_browser' => false,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new TamperingDetails();

        $this->assertNull($model->getAnomalyScore());
        $this->assertNull($model->getAntiDetectBrowser());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new TamperingDetails(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['anomaly_score'], $model->getAnomalyScore());
        $this->assertEquals(self::EXAMPLE['anti_detect_browser'], $model->getAntiDetectBrowser());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new TamperingDetails();

        $this->assertSame($model, $model->setAnomalyScore(self::EXAMPLE['anomaly_score']));
        $this->assertSame($model, $model->setAntiDetectBrowser(self::EXAMPLE['anti_detect_browser']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new TamperingDetails(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), TamperingDetails::class);

        $this->assertEquals($model->getAnomalyScore(), $deserialized->getAnomalyScore());
        $this->assertEquals($model->getAntiDetectBrowser(), $deserialized->getAntiDetectBrowser());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new TamperingDetails();

        $model['anomaly_score'] = self::EXAMPLE['anomaly_score'];
        $this->assertEquals(self::EXAMPLE['anomaly_score'], $model['anomaly_score']);
        $this->assertTrue(isset($model['anomaly_score']));

        unset($model['anomaly_score']);
        $this->assertNull($model['anomaly_score']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new TamperingDetails();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new TamperingDetails(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['anomaly_score'], $decoded['anomaly_score']);
        $this->assertEquals(self::EXAMPLE['anti_detect_browser'], $decoded['anti_detect_browser']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new TamperingDetails();

        $this->assertEquals('TamperingDetails', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new TamperingDetails();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new TamperingDetails(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['anomaly_score'], $serialized->anomaly_score);
        $this->assertEquals(self::EXAMPLE['anti_detect_browser'], $serialized->anti_detect_browser);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new TamperingDetails(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['anomaly_score'], $decoded['anomaly_score']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
