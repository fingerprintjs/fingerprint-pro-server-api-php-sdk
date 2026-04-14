<?php

namespace Fingerprint\ServerSdk\Test;

use Fingerprint\ServerSdk\Configuration;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Configuration::class)]
final class ConfigurationTest extends TestCase
{
    /**
     * Constructor should set the API key passed.
     */
    public function testConstructorSetsApiKey(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertEquals('test-api-key', $config->getApiKey());
    }

    /**
     * setApiKey should override the API key.
     */
    public function testSetAndGetApiKey(): void
    {
        $config = new Configuration('test-api-key');
        $config->setApiKey('updated');

        $this->assertEquals('updated', $config->getApiKey());
    }

    /**
     * Constructor should default to the global region when no region is provided.
     */
    public function testConstructorDefaultsToGlobalRegion(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    /**
     * setRegion should accept the "eu", "asia", "as" and "global" shorthand identifiers.
     */
    public function testSetRegionWithShorthand(): void
    {
        $config = new Configuration('test-api-key');

        $config->setRegion('eu');
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());

        $config->setRegion('europe');
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());

        $config->setRegion('as');
        $this->assertEquals(Configuration::REGION_ASIA, $config->getHost());

        $config->setRegion('asia');
        $this->assertEquals(Configuration::REGION_ASIA, $config->getHost());

        $config->setRegion('global');
        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    /**
     * setRegion should accept the full host URL constants.
     */
    public function testSetRegionWithFullUrl(): void
    {
        $config = new Configuration('test-api-key');

        $config->setRegion(Configuration::REGION_EUROPE);
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());

        $config->setRegion(Configuration::REGION_ASIA);
        $this->assertEquals(Configuration::REGION_ASIA, $config->getHost());

        /* @noinspection PhpRedundantOptionalArgumentInspection */
        $config->setRegion(Configuration::REGION_GLOBAL);
        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    /**
     * setRegion should be case-insensitive and tolerate surrounding whitespace.
     */
    public function testSetRegionIsCaseInsensitiveAndTrimmed(): void
    {
        $config = new Configuration('test-api-key');

        $config->setRegion('  EU  ');
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());

        $config->setRegion('ASIA');
        $this->assertEquals(Configuration::REGION_ASIA, $config->getHost());

        $config->setRegion('Global');
        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    /**
     * Unknown region values should fall back to the global host.
     */
    public function testSetRegionWithUnknownValueFallsBackToGlobal(): void
    {
        $config = new Configuration('test-api-key', Configuration::REGION_EUROPE);

        $config->setRegion('unknown');

        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    /**
     * setHost should override the host.
     */
    public function testSetAndGetHost(): void
    {
        $config = new Configuration('test-api-key');

        $config->setHost('https://custom.example.com');

        $this->assertEquals('https://custom.example.com', $config->getHost());
    }

    /**
     * setUserAgent should override the default user agent string.
     */
    public function testSetAndGetUserAgent(): void
    {
        $config = new Configuration('test-api-key');

        $config->setUserAgent('custom-agent/1.0');

        $this->assertEquals('custom-agent/1.0', $config->getUserAgent());
    }

    /**
     * Debug flag should default to false and updates with setDebug.
     */
    public function testSetAndGetDebug(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertFalse($config->getDebug());

        $config->setDebug(true);
        $this->assertTrue($config->getDebug());
    }

    /**
     * Debug file should default to php://output and be overridable.
     */
    public function testSetAndGetDebugFile(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertEquals('php://output', $config->getDebugFile());

        $config->setDebugFile('/tmp/debug.log');
        $this->assertEquals('/tmp/debug.log', $config->getDebugFile());
    }

    /**
     * Temp folder path should default to the system temp dir and be overridable.
     */
    public function testSetAndGetTempFolderPath(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertEquals(sys_get_temp_dir(), $config->getTempFolderPath());

        $config->setTempFolderPath('/tmp/custom');
        $this->assertEquals('/tmp/custom', $config->getTempFolderPath());
    }

    /**
     * mTLS certificate file should default to null and be overridable.
     */
    public function testSetAndGetCertFile(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertNull($config->getCertFile());

        $config->setCertFile('/cert.pem');
        $this->assertEquals('/cert.pem', $config->getCertFile());
    }

    /**
     * mTLS key file should default to null, be overridable, and resettable to null.
     */
    public function testSetAndGetKeyFile(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertNull($config->getKeyFile());

        $config->setKeyFile('/path/to/key.pem');
        $this->assertEquals('/path/to/key.pem', $config->getKeyFile());

        $config->setKeyFile(null);
        $this->assertNull($config->getKeyFile());
    }

    /**
     * Setter methods should return the Configuration instance to support chaining.
     */
    public function testSettersReturnSelfForChaining(): void
    {
        $config = new Configuration('test-api-key');

        $this->assertSame($config, $config->setApiKey('new'));
        $this->assertSame($config, $config->setHost('https://example.com'));
        $this->assertSame($config, $config->setRegion('eu'));
        $this->assertSame($config, $config->setUserAgent('agent'));
        $this->assertSame($config, $config->setDebug(true));
        $this->assertSame($config, $config->setDebugFile('php://stderr'));
        $this->assertSame($config, $config->setTempFolderPath('/tmp'));
        $this->assertSame($config, $config->setCertFile('/cert'));
        $this->assertSame($config, $config->setKeyFile('/key'));
    }

    /**
     * toDebugReport static function should include OS, PHP version, API document version and SDK package version.
     */
    public function testToDebugReport(): void
    {
        $report = Configuration::toDebugReport();

        $this->assertStringContainsString('PHP SDK (Fingerprint\ServerSdk) Debug Report:', $report);
        $this->assertStringContainsString('OS: '.php_uname(), $report);
        $this->assertStringContainsString('PHP Version: '.PHP_VERSION, $report);
        $this->assertStringContainsString('The version of the OpenAPI document: 4', $report);
        $this->assertStringContainsString('SDK Package Version: '.Configuration::VERSION, $report);
    }
}
