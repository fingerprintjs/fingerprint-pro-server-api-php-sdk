<?php

namespace Fingerprint\ServerAPI\Webhook;

final class WebhookVerifier
{
    public static function IsValidWebhookSignature(string $header, string $data, string $secret): bool
    {
        $signatures = explode(',', $header);
        foreach ($signatures as $signature) {
            $parts = explode('=', $signature);
            if (2 === count($parts) && 'v1' === $parts[0]) {
                $hash = $parts[1];
                if (self::checkSignature($hash, $data, $secret)) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function checkSignature(string $signature, string $data, string $secret): bool
    {
        $hash = hash_hmac('sha256', $data, $secret);

        return hash_equals($hash, $signature);
    }
}
