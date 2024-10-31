<?php

namespace Fingerprint\ServerAPI\Sealed;

use Fingerprint\ServerAPI\Model\EventsGetResponse;
use Fingerprint\ServerAPI\ObjectSerializer;
use Fingerprint\ServerAPI\SerializationException;
use GuzzleHttp\Psr7\Response;

class Sealed
{
    private const NONCE_LENGTH = 12;
    private const AUTH_TAG_LENGTH = 16;
    private static $SEAL_HEADER = "\x9E\x85\xDC\xED";

    /**
     * @param DecryptionKey[] $keys
     *
     * @throws UnsealAggregateException
     * @throws SerializationException
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
     * @param string          $sealed Base64 encoded sealed data
     * @param DecryptionKey[] $keys   Decryption keys. The SDK will try to decrypt the result with each key until it succeeds.
     *
     * @throws UnsealAggregateException
     */
    public static function unseal(string $sealed, array $keys): string
    {
        if (substr($sealed, 0, strlen(self::$SEAL_HEADER)) !== self::$SEAL_HEADER) {
            throw new InvalidSealedDataHeaderException();
        }

        $aggregateException = new UnsealAggregateException();

        foreach ($keys as $key) {
            switch ($key->getAlgorithm()) {
                case DecryptionAlgorithm::AES_256_GCM:
                    try {
                        $data = substr($sealed, strlen(self::$SEAL_HEADER));

                        return self::decryptAes256Gcm($data, $key->getKey());
                    } catch (\Exception $exception) {
                        $aggregateException->addException(new UnsealException(
                            'Failed to decrypt',
                            $exception,
                            $key
                        ));
                    }

                    break;

                default:
                    throw new \InvalidArgumentException('Invalid decryption algorithm');
            }
        }

        throw $aggregateException;
    }

    /**
     * @param mixed $sealedData
     * @param mixed $decryptionKey
     *
     * @throws \Exception
     */
    private static function decryptAes256Gcm($sealedData, $decryptionKey): string
    {
        $nonce = substr($sealedData, 0, self::NONCE_LENGTH);
        $ciphertext = substr($sealedData, self::NONCE_LENGTH);

        $tag = substr($ciphertext, -self::AUTH_TAG_LENGTH);
        $ciphertext = substr($ciphertext, 0, -self::AUTH_TAG_LENGTH);

        $decryptedData = openssl_decrypt($ciphertext, 'aes-256-gcm', $decryptionKey, OPENSSL_RAW_DATA, $nonce, $tag);

        if (false === $decryptedData) {
            throw new \Exception('Decryption failed');
        }

        return self::decompress($decryptedData);
    }

    /**
     * @param mixed $data
     *
     * @throws \Exception
     */
    private static function decompress($data): string
    {
        if (false === $data || 0 === strlen($data)) {
            throw new DecompressionException();
        }
        $inflated = @gzinflate($data); // Ignore warnings, because we check the decompressed data's validity and throw error if necessary

        if (false === $inflated) {
            throw new DecompressionException();
        }

        return $inflated;
    }
}
