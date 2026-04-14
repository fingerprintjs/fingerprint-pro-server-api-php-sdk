<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\BrowserDetails;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(BrowserDetails::class)]
class BrowserDetailsTest extends TestCase
{
    private const EXAMPLE = [
        'browser_name' => 'Chrome',
        'browser_major_version' => '120',
        'browser_full_version' => '120.0.6099',
        'os' => 'Windows',
        'os_version' => '10',
        'device' => 'Desktop',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new BrowserDetails();

        $this->assertNull($model->getBrowserName());
        $this->assertNull($model->getBrowserMajorVersion());
        $this->assertNull($model->getBrowserFullVersion());
        $this->assertNull($model->getOs());
        $this->assertNull($model->getOsVersion());
        $this->assertNull($model->getDevice());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new BrowserDetails(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['browser_name'], $model->getBrowserName());
        $this->assertEquals(self::EXAMPLE['browser_major_version'], $model->getBrowserMajorVersion());
        $this->assertEquals(self::EXAMPLE['browser_full_version'], $model->getBrowserFullVersion());
        $this->assertEquals(self::EXAMPLE['os'], $model->getOs());
        $this->assertEquals(self::EXAMPLE['os_version'], $model->getOsVersion());
        $this->assertEquals(self::EXAMPLE['device'], $model->getDevice());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new BrowserDetails();

        $this->assertSame($model, $model->setBrowserName(self::EXAMPLE['browser_name']));
        $this->assertSame($model, $model->setBrowserMajorVersion(self::EXAMPLE['browser_major_version']));
        $this->assertSame($model, $model->setBrowserFullVersion(self::EXAMPLE['browser_full_version']));
        $this->assertSame($model, $model->setOs(self::EXAMPLE['os']));
        $this->assertSame($model, $model->setOsVersion(self::EXAMPLE['os_version']));
        $this->assertSame($model, $model->setDevice(self::EXAMPLE['device']));
    }

    /**
     * Serialization should preserve all property values.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new BrowserDetails(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), BrowserDetails::class);

        $this->assertEquals($model->getBrowserName(), $deserialized->getBrowserName());
        $this->assertEquals($model->getBrowserMajorVersion(), $deserialized->getBrowserMajorVersion());
        $this->assertEquals($model->getBrowserFullVersion(), $deserialized->getBrowserFullVersion());
        $this->assertEquals($model->getOs(), $deserialized->getOs());
        $this->assertEquals($model->getOsVersion(), $deserialized->getOsVersion());
        $this->assertEquals($model->getDevice(), $deserialized->getDevice());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new BrowserDetails();

        $model['browser_name'] = self::EXAMPLE['browser_name'];
        $this->assertEquals(self::EXAMPLE['browser_name'], $model['browser_name']);
        $this->assertTrue(isset($model['browser_name']));

        unset($model['browser_name']);
        $this->assertNull($model['browser_name']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not.
     */
    public function testValidation(): void
    {
        $emptyModel = new BrowserDetails();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new BrowserDetails(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new BrowserDetails(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['browser_name'], $decoded['browser_name']);
        $this->assertEquals(self::EXAMPLE['os'], $decoded['os']);
        $this->assertEquals(self::EXAMPLE['device'], $decoded['device']);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new BrowserDetails(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('browser_name'));
        $this->assertFalse($model->isNullableSetToNull('os'));
        $this->assertFalse($model->isNullableSetToNull('device'));
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new BrowserDetails();

        $this->assertEquals('BrowserDetails', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new BrowserDetails();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new BrowserDetails(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['browser_name'], $serialized->browser_name);
        $this->assertEquals(self::EXAMPLE['os'], $serialized->os);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new BrowserDetails(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['browser_name'], $decoded['browser_name']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['browser_name'] = null;

        $model = new BrowserDetails($data);

        $this->assertNull($model->getBrowserName());
        $this->assertFalse($model->isNullableSetToNull('browser_name'));
    }
}
