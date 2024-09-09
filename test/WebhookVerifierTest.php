<?php

namespace Fingerprint\ServerAPI;

use Fingerprint\ServerAPI\Webhook\WebhookVerifier;
use PHPUnit\Framework\TestCase;

class WebhookVerifierTest extends TestCase
{
    private $secret = 'secret';
    private $data = 'data';

    public function testWithValidSignature()
    {
        $validHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
        $result = WebhookVerifier::IsValidWebhookSignature($validHeader, $this->data, $this->secret);
        $this->assertTrue($result, 'With valid signature');
    }

    public function testWithInvalidHeader()
    {
        $result = WebhookVerifier::IsValidWebhookSignature('v2=invalid', $this->data, $this->secret);
        $this->assertFalse($result, 'With invalid header');
    }

    public function testWithHeaderWithoutVersion()
    {
        $result = WebhookVerifier::IsValidWebhookSignature('invalid', $this->data, $this->secret);
        $this->assertFalse($result, 'With header without version');
    }

    public function testWithEmptyHeader()
    {
        $result = WebhookVerifier::IsValidWebhookSignature('', $this->data, $this->secret);
        $this->assertFalse($result, 'With empty header');
    }

    public function testWithEmptySecret()
    {
        $validHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
        $result = WebhookVerifier::IsValidWebhookSignature($validHeader, $this->data, '');
        $this->assertFalse($result, 'With empty secret');
    }

    public function testWithEmptyData()
    {
        $validHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
        $result = WebhookVerifier::IsValidWebhookSignature($validHeader, '', $this->secret);
        $this->assertFalse($result, 'With empty data');
    }
}
