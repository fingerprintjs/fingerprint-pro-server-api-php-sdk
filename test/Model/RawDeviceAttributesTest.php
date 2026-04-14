<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\RawDeviceAttributes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(RawDeviceAttributes::class)]
class RawDeviceAttributesTest extends TestCase
{
    private const EXAMPLE = [
        'timezone' => 'America/New_York',
        'device_memory' => 8,
        'architecture' => 64,
        'cookies_enabled' => true,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new RawDeviceAttributes();

        $this->assertNull($model->getFontPreferences());
        $this->assertNull($model->getEmoji());
        $this->assertNull($model->getFonts());
        $this->assertNull($model->getDeviceMemory());
        $this->assertNull($model->getTimezone());
        $this->assertNull($model->getCanvas());
        $this->assertNull($model->getLanguages());
        $this->assertNull($model->getWebglExtensions());
        $this->assertNull($model->getWebglBasics());
        $this->assertNull($model->getScreenResolution());
        $this->assertNull($model->getTouchSupport());
        $this->assertNull($model->getOscpu());
        $this->assertNull($model->getArchitecture());
        $this->assertNull($model->getCookiesEnabled());
        $this->assertNull($model->getHardwareConcurrency());
        $this->assertNull($model->getDateTimeLocale());
        $this->assertNull($model->getVendor());
        $this->assertNull($model->getColorDepth());
        $this->assertNull($model->getPlatform());
        $this->assertNull($model->getSessionStorage());
        $this->assertNull($model->getLocalStorage());
        $this->assertNull($model->getAudio());
        $this->assertNull($model->getPlugins());
        $this->assertNull($model->getIndexedDb());
        $this->assertNull($model->getMath());
    }

    /**
     * Constructor should accept an array and populate the scalar properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new RawDeviceAttributes(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['timezone'], $model->getTimezone());
        $this->assertEquals(self::EXAMPLE['device_memory'], $model->getDeviceMemory());
        $this->assertEquals(self::EXAMPLE['architecture'], $model->getArchitecture());
        $this->assertEquals(self::EXAMPLE['cookies_enabled'], $model->getCookiesEnabled());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new RawDeviceAttributes();

        $this->assertSame($model, $model->setTimezone(self::EXAMPLE['timezone']));
        $this->assertSame($model, $model->setDeviceMemory(self::EXAMPLE['device_memory']));
        $this->assertSame($model, $model->setArchitecture(self::EXAMPLE['architecture']));
        $this->assertSame($model, $model->setCookiesEnabled(self::EXAMPLE['cookies_enabled']));
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new RawDeviceAttributes();

        $model['timezone'] = self::EXAMPLE['timezone'];
        $this->assertEquals(self::EXAMPLE['timezone'], $model['timezone']);
        $this->assertTrue(isset($model['timezone']));

        unset($model['timezone']);
        $this->assertNull($model['timezone']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new RawDeviceAttributes();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a valid JSON representation.
     */
    public function testToString(): void
    {
        $model = new RawDeviceAttributes(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['timezone'], $decoded['timezone']);
        $this->assertEquals(self::EXAMPLE['device_memory'], $decoded['device_memory']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new RawDeviceAttributes();

        $this->assertEquals('RawDeviceAttributes', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new RawDeviceAttributes();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new RawDeviceAttributes(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['timezone'], $serialized->timezone);
        $this->assertEquals(self::EXAMPLE['device_memory'], $serialized->device_memory);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new RawDeviceAttributes(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['timezone'], $decoded['timezone']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
