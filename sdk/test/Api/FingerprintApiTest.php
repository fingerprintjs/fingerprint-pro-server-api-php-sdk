<?php

namespace Fingerprintjs\ServerAPI;

use Fingerprintjs\ServerAPI\Api\FingerprintApi;
use PHPUnit_Framework_TestCase;

class FingerprintApiTest extends PHPUnit_Framework_TestCase
{
    protected $fingerprint_api;

    public function setUp()
    {
        $config = new Configuration();
        $config->setHost(getenv('FP_API_HOST'));
        $config->setApiKey('api_key', getenv('FP_PRIVATE_API_KEY'));
        $this->fingerprint_api = new FingerprintApi(null, $config);
    }

    public function testGetEvent()
    {
        $event = $this->fingerprint_api->getEvent('1');
    }

    public function testGetVisits()
    {
        $visits = $this->fingerprint_api->getVisits('1');
    }
}
