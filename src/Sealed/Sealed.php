<?php

namespace Fingerprint\ServerAPI\Sealed;

use Exception;
use Fingerprint\ServerAPI\Model\EventsGetResponse;
use Fingerprint\ServerAPI\ObjectSerializer;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

/**
 * Provides methods to decrypt and deserialize sealed results.
 *
 * Sealed results are encrypted and compressed payloads.
 */
class Sealed
{
    /** @var int AES-256-GCM nonce length in bytes. */
    private const NONCE_LENGTH = 12;

    /** @var int AES-256-GCM authentication tag length in bytes. */
    private const AUTH_TAG_LENGTH = 16;

    /** @var string Magic bytes that prefix every sealed payload. */
    private const SEAL_HEADER = "\x9E\x85\xDC\xED";

    /**
     * Unseals and deserializes a sealed response into an EventsGetResponse.
     *
     * @param string          $sealed raw sealed payload
     * @param DecryptionKey[] $keys   decryption keys to try in order
     *
     * @throws UnsealAggregateException   when decryption fails with every provided key
     * @throws InvalidSealedDataException when decrypted payload is not a valid event response
     * @throws Exception
     */
    public static function unsealEventResponse(string $sealed, array $keys): EventsGetResponse
    {
        $unsealed = self::unseal($sealed, $keys);

        $data = json_decode($unsealed, true);

        if (!isset($data['products'])) {
            throw new InvalidSealedDataException();
        }

        $response = new Response(200, [], $unsealed);

        return ObjectSerializer::deserialize($response, EventsGetResponse::class);
    }

    /**
     * Decrypts the sealed response with the provided keys.
     *
     * Tries each key in order; returns the decrypted plaintext on the first
     * successful decryption. If all keys fail, throws an aggregate exception.
     *
     * @param string          $sealed raw sealed payload
     * @param DecryptionKey[] $keys   decryption keys to try in order
     *
     * @throws UnsealAggregateException when decryption fails with every provided key
     */
    public static function unseal(string $sealed, array $keys): string
    {
        if (!str_starts_with($sealed, self::SEAL_HEADER)) {
            throw new InvalidSealedDataHeaderException();
        }

        $aggregateException = new UnsealAggregateException();

        foreach ($keys as $key) {
            switch ($key->getAlgorithm()) {
                case DecryptionAlgorithm::AES_256_GCM:
                    try {
                        $data = substr($sealed, strlen(self::SEAL_HEADER));

                        return self::decryptAes256Gcm($data, $key->getKey());
                    } catch (Exception $exception) {
                        $aggregateException->addException(new UnsealException(
                            'Failed to decrypt',
                            $exception,
                            $key
                        ));
                    }

                    break;

                default:
                    throw new InvalidArgumentException('Invalid decryption algorithm');
            }
        }

        throw $aggregateException;
    }

    /**
     * Decrypts an AES-256-GCM payload and decompresses the result.
     *
     * @param string $sealedData    nonce + ciphertext + auth tag
     * @param string $decryptionKey raw 256-bit key
     *
     * @return string decompressed plaintext
     *
     * @throws Exception on decryption failure
     */
    private static function decryptAes256Gcm(string $sealedData, string $decryptionKey): string
    {
        $nonce = substr($sealedData, 0, self::NONCE_LENGTH);
        $ciphertext = substr($sealedData, self::NONCE_LENGTH);

        $tag = substr($ciphertext, -self::AUTH_TAG_LENGTH);
        $ciphertext = substr($ciphertext, 0, -self::AUTH_TAG_LENGTH);

        $decryptedData = openssl_decrypt($ciphertext, 'aes-256-gcm', $decryptionKey, OPENSSL_RAW_DATA, $nonce, $tag);

        if (false === $decryptedData) {
            throw new Exception('Decryption failed');
        }

        return self::decompress($decryptedData);
    }

    /**
     * Decompresses raw-deflated data.
     *
     * @param bool|string $data raw deflate-compressed data
     *
     * @return string decompressed data
     *
     * @throws DecompressionException when decompression fails or input is empty
     */
    private static function decompress(bool|string $data): string
    {
        if (false === $data || 0 === strlen($data)) {
            throw new DecompressionException();
        }

        // Ignore warnings, because we check the decompressed data's validity and throw error if necessary
        $inflated = @gzinflate($data);

        if (false === $inflated) {
            throw new DecompressionException();
        }

        return $inflated;
    }
}
