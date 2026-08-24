<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Canvas;
use Fingerprint\ServerSdk\Model\Emoji;
use Fingerprint\ServerSdk\Model\FontPreferences;
use Fingerprint\ServerSdk\Model\PluginsInner;
use Fingerprint\ServerSdk\Model\RawDeviceAttributes;
use Fingerprint\ServerSdk\Model\TouchSupport;
use Fingerprint\ServerSdk\Model\WebGlBasics;
use Fingerprint\ServerSdk\Model\WebGlExtensions;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(RawDeviceAttributes::class)]
class RawDeviceAttributesTest extends TestCase
{
    public function testAllGettersAndSetters(): void
    {
        $model = new RawDeviceAttributes();

        $model->setArchitecture(127);
        $this->assertSame(127, $model->getArchitecture());

        $model->setAudio(0.5);
        $this->assertSame(0.5, $model->getAudio());

        $canvas = new Canvas();
        $model->setCanvas($canvas);
        $this->assertSame($canvas, $model->getCanvas());

        $model->setColorDepth(24);
        $this->assertSame(24, $model->getColorDepth());

        $model->setCookiesEnabled(true);
        $this->assertTrue($model->getCookiesEnabled());

        $model->setDeviceMemory(8);
        $this->assertSame(8, $model->getDeviceMemory());

        $emoji = new Emoji();
        $model->setEmoji($emoji);
        $this->assertSame($emoji, $model->getEmoji());

        $fontPrefs = new FontPreferences();
        $model->setFontPreferences($fontPrefs);
        $this->assertSame($fontPrefs, $model->getFontPreferences());

        $model->setFonts([]);
        $this->assertSame([], $model->getFonts());

        $model->setHardwareConcurrency(8);
        $this->assertSame(8, $model->getHardwareConcurrency());

        $model->setIndexedDb(true);
        $this->assertTrue($model->getIndexedDb());

        $model->setLanguages([['en-US', 'en'], ['en-GB', 'en']]);
        $this->assertSame([['en-US', 'en'], ['en-GB', 'en']], $model->getLanguages());

        $model->setLocalStorage(true);
        $this->assertTrue($model->getLocalStorage());

        $model->setMath('12345');
        $this->assertSame('12345', $model->getMath());

        $model->setOscpu('Linux x86_64');
        $this->assertSame('Linux x86_64', $model->getOscpu());

        $model->setPlatform('Linux');
        $this->assertSame('Linux', $model->getPlatform());

        $plugin = new PluginsInner();
        $model->setPlugins([$plugin]);
        $this->assertCount(1, $model->getPlugins());

        $model->setScreenResolution([1920, 1080]);
        $this->assertSame([1920, 1080], $model->getScreenResolution());

        $model->setSessionStorage(true);
        $this->assertTrue($model->getSessionStorage());

        $touchSupport = new TouchSupport();
        $model->setTouchSupport($touchSupport);
        $this->assertSame($touchSupport, $model->getTouchSupport());

        $model->setVendor('Google Inc.');
        $this->assertSame('Google Inc.', $model->getVendor());

        $model->setTimezone('America/New_York');
        $this->assertSame('America/New_York', $model->getTimezone());

        $model->setTimezoneOffset('-300');
        $this->assertSame('-300', $model->getTimezoneOffset());

        $webGlBasics = new WebGlBasics();
        $model->setWebglBasics($webGlBasics);
        $this->assertSame($webGlBasics, $model->getWebglBasics());

        $webGlExt = new WebGlExtensions();
        $model->setWebglExtensions($webGlExt);
        $this->assertSame($webGlExt, $model->getWebglExtensions());

        $model->setDateTimeLocale('en-US');
        $this->assertSame('en-US', $model->getDateTimeLocale());

        $model->setDeviceModel('Pixel 7');
        $this->assertSame('Pixel 7', $model->getDeviceModel());

        $model->setDeviceManufacturer('Google');
        $this->assertSame('Google', $model->getDeviceManufacturer());

        $model->setFontHash('abc123');
        $this->assertSame('abc123', $model->getFontHash());

        $model->setBatteryLevel(85);
        $this->assertSame(85, $model->getBatteryLevel());

        $model->setBatteryLowPowerMode(false);
        $this->assertFalse($model->getBatteryLowPowerMode());

        $model->setBatteryCharging(true);
        $this->assertTrue($model->getBatteryCharging());

        $model->setKeyboardLayoutHash('691e3845c85c202a1514b6fd7ef17065');
        $this->assertSame('691e3845c85c202a1514b6fd7ef17065', $model->getKeyboardLayoutHash());

        $model->setKeyboardLayoutName('en-US');
        $this->assertSame('en-US', $model->getKeyboardLayoutName());
    }

    public function testDeviceMemoryLowerBoundValidation(): void
    {
        $model = new RawDeviceAttributes();
        $this->expectException(\InvalidArgumentException::class);
        $model->setDeviceMemory(-1);
    }

    public function testBatteryLevelUpperBoundValidation(): void
    {
        $model = new RawDeviceAttributes();
        $this->expectException(\InvalidArgumentException::class);
        $model->setBatteryLevel(101);
    }

    public function testBatteryLevelLowerBoundValidation(): void
    {
        $model = new RawDeviceAttributes();
        $this->expectException(\InvalidArgumentException::class);
        $model->setBatteryLevel(-1);
    }

    public function testScreenResolutionTooManyValidation(): void
    {
        $model = new RawDeviceAttributes();
        $this->expectException(\InvalidArgumentException::class);
        $model->setScreenResolution([1920, 1080, 32]);
    }

    public function testScreenResolutionTooFewValidation(): void
    {
        $model = new RawDeviceAttributes();
        $this->expectException(\InvalidArgumentException::class);
        $model->setScreenResolution([1920]);
    }

    public function testListInvalidProperties(): void
    {
        $model = new RawDeviceAttributes([
            'device_memory' => -5,
            'battery_level' => 150,
            'screen_resolution' => [1],
        ]);
        $invalid = $model->listInvalidProperties();
        $this->assertNotEmpty($invalid);
    }

    public function testValidModel(): void
    {
        $model = new RawDeviceAttributes();
        $this->assertTrue($model->valid());
    }

    public function testJsonSerialize(): void
    {
        $model = new RawDeviceAttributes(['architecture' => 127]);
        $json = json_encode($model);
        $decoded = json_decode($json, true);
        $this->assertSame(127, $decoded['architecture']);
    }

    public function testToStringAndToHeaderValue(): void
    {
        $model = new RawDeviceAttributes(['architecture' => 127]);
        $this->assertStringContainsString('127', (string) $model);
        $this->assertIsString($model->toHeaderValue());
    }

    public function testStaticMethods(): void
    {
        $this->assertIsArray(RawDeviceAttributes::openAPITypes());
        $this->assertIsArray(RawDeviceAttributes::openAPIFormats());
        $this->assertIsArray(RawDeviceAttributes::attributeMap());
        $this->assertIsArray(RawDeviceAttributes::setters());
        $this->assertIsArray(RawDeviceAttributes::getters());
        $this->assertSame('RawDeviceAttributes', (new RawDeviceAttributes())->getModelName());
    }

    public function testIsNullableSetToNullPath(): void
    {
        $model = new RawDeviceAttributes();
        $this->assertIsBool($model->isNullableSetToNull('architecture'));
    }

    public function testArrayAccess(): void
    {
        $model = new RawDeviceAttributes(['architecture' => 127]);

        $this->assertTrue(isset($model['architecture']));
        $this->assertSame(127, $model['architecture']);

        $model['color_depth'] = 24;
        $this->assertSame(24, $model['color_depth']);

        unset($model['color_depth']);
        $this->assertNull($model['color_depth']);
    }

    public function testArrayAccessWithNullOffset(): void
    {
        $model = new RawDeviceAttributes();
        $model[] = 'appended';
        $this->assertSame('appended', $model[0]);
    }

    public function testListInvalidPropertiesScreenResolutionTooMany(): void
    {
        $model = new RawDeviceAttributes(['screen_resolution' => [1920, 1080, 32]]);
        $invalid = $model->listInvalidProperties();
        $this->assertNotEmpty($invalid);
    }

    public function testListInvalidPropertiesBatteryLevelTooLow(): void
    {
        $model = new RawDeviceAttributes(['battery_level' => -1]);
        $invalid = $model->listInvalidProperties();
        $this->assertNotEmpty($invalid);
    }
}
