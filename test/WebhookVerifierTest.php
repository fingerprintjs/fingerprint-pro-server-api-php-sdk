<?php

namespace Fingerprint\ServerAPI;

use Fingerprint\ServerAPI\Webhook\WebhookVerifier;
use PHPUnit\Framework\TestCase;

/**
 * Tests for webhook signature verification.
 */
class WebhookVerifierTest extends TestCase
{
    private string $secret = 'secret';
    private string $data = 'data';

    /**
     * Verifies that a valid v1 signature is accepted.
     */
    public function testWithValidSignature(): void
    {
        /** @noinspection SpellCheckingInspection */
        $validHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
        $result = WebhookVerifier::IsValidWebhookSignature($validHeader, $this->data, $this->secret);
        $this->assertTrue($result, 'With valid signature');
    }

    /**
     * Verifies that a non-v1 signature version is rejected.
     */
    public function testWithInvalidHeader(): void
    {
        $result = WebhookVerifier::IsValidWebhookSignature('v2=invalid', $this->data, $this->secret);
        $this->assertFalse($result, 'With invalid header');
    }

    /**
     * Verifies that a header without a version prefix is rejected.
     */
    public function testWithHeaderWithoutVersion(): void
    {
        $result = WebhookVerifier::IsValidWebhookSignature('invalid', $this->data, $this->secret);
        $this->assertFalse($result, 'With header without version');
    }

    /**
     * Verifies that an empty header is rejected.
     */
    public function testWithEmptyHeader(): void
    {
        $result = WebhookVerifier::IsValidWebhookSignature('', $this->data, $this->secret);
        $this->assertFalse($result, 'With empty header');
    }

    /**
     * Verifies that an empty secret never matches.
     */
    public function testWithEmptySecret(): void
    {
        /** @noinspection SpellCheckingInspection */
        $validHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
        $result = WebhookVerifier::IsValidWebhookSignature($validHeader, $this->data, '');
        $this->assertFalse($result, 'With empty secret');
    }

    /**
     * Verifies that empty data does not match a signature computed with non-empty data.
     */
    public function testWithEmptyData(): void
    {
        /** @noinspection SpellCheckingInspection */
        $validHeader = 'v1=1b2c16b75bd2a870c114153ccda5bcfca63314bc722fa160d690de133ccbb9db';
        $result = WebhookVerifier::IsValidWebhookSignature($validHeader, '', $this->secret);
        $this->assertFalse($result, 'With empty data');
    }
}
