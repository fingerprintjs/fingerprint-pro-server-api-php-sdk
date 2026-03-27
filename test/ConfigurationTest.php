<?php

namespace Fingerprint\ServerAPI;

use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    protected function setUp(): void
    {
        Configuration::setDefaultConfiguration(new Configuration());
    }

    public function testSetRegionWithShorthand(): void
    {
        $config = new Configuration();

        $config->setRegion('eu');
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());

        $config->setRegion('asia');
        $this->assertEquals(Configuration::REGION_ASIA, $config->getHost());

        $config->setRegion('global');
        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    public function testSetRegionWithFullUrl(): void
    {
        $config = new Configuration();

        $config->setRegion(Configuration::REGION_EUROPE);
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());

        $config->setRegion(Configuration::REGION_ASIA);
        $this->assertEquals(Configuration::REGION_ASIA, $config->getHost());

        /** @noinspection PhpRedundantOptionalArgumentInspection */
        $config->setRegion(Configuration::REGION_GLOBAL);
        $this->assertEquals(Configuration::REGION_GLOBAL, $config->getHost());
    }

    public function testGetDefaultConfiguration(): void
    {
        $config = Configuration::getDefaultConfiguration('test-api-key', Configuration::REGION_EUROPE);

        $this->assertInstanceOf(Configuration::class, $config);
        $this->assertEquals('test-api-key', $config->getApiKey('api_key'));
        $this->assertEquals(Configuration::REGION_EUROPE, $config->getHost());
    }

    public function testGetApiKeyWithPrefix(): void
    {
        $config = new Configuration();
        $config->setApiKey('api_key', 'my-key');
        $config->setApiKeyPrefix('api_key', 'Bearer');

        $this->assertEquals('Bearer my-key', $config->getApiKeyWithPrefix('api_key'));
    }

    public function testGetApiKeyWithPrefixNoPrefix(): void
    {
        $config = new Configuration();
        $config->setApiKey('api_key', 'my-key');

        $this->assertEquals('my-key', $config->getApiKeyWithPrefix('api_key'));
    }

    public function testGetApiKeyWithPrefixNoKey(): void
    {
        $config = new Configuration();

        $this->assertNull($config->getApiKeyWithPrefix('api_key'));
    }

}
