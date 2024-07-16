<?php

namespace Fingerprint\ServerAPI\Api;

use Fingerprint\ServerAPI\Model\EventResponse;
use Fingerprint\ServerAPI\Model\Response;
use Fingerprint\ServerAPI\ObjectSerializer;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use RuntimeException;

class FingerprintApi
{
    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;
    /**
     * @var Configuration
     */
    protected Configuration $config;

    protected string $integration_info = 'fingerprint-pro-server-php-sdk/{version}';

    /**
     * @param ClientInterface|null $client
     * @param Configuration|null $config
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration   $config = null
    )
    {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();

        $this->integration_info = str_replace("{version}", $this->getSDKVersion(), $this->integration_info);
    }

    protected function getSDKVersion(): string
    {
        $string = file_get_contents(dirname(__FILE__) . "/../../composer.json");
        $jsonData = json_decode($string, true);

        return $jsonData['version'];
    }

    protected function getEventURL(): string
    {
        return $this->config->getHost() . "/events/{request_id}";
    }

    protected function getVisitsURL(): string
    {
        return $this->config->getHost() . "/visitors/{visitor_id}";
    }

    protected function getClientOptions(): array
    {
        $options = [
            'headers' => [
                'User-Agent' => $this->config->getUserAgent(),
                'Content-Type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json; charset=utf-8',
            ],
            'query' => [
                'ii' => $this->integration_info,
            ]
        ];

        $apiKey = $this->config->getApiKeyWithPrefix('Auth-API-Key');
        if ($apiKey !== null) {
            $options['headers']['Auth-API-Key'] = $apiKey;
        }

        $apiKey = $this->config->getApiKeyWithPrefix('api_key');
        if ($apiKey !== null) {
            $options['query']['api_key'] = $apiKey;
        }

        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }

    protected function getEventRequest(string $request_id): Request
    {
        $options = $this->getClientOptions();
        $url = str_replace("{request_id}", $request_id, $this->getEventURL()) . "?" . http_build_query($options['query']);
        return new Request('GET', $url, $options['headers']);
    }

    public function getEvent(string $request_id): EventResponse
    {
        $response = $this->client->sendRequest($this->getEventRequest($request_id));
        $content = $response->getBody()->getContents();
        /** @var EventResponse $serialized */
        $serialized = ObjectSerializer::deserialize($content, EventResponse::class, []);
        $serialized->setRawResponse($content);

        return $serialized;
    }

    protected function getVisitsRequest(string $visitor_id, string|null $request_id = null, string|null $linked_id = null, string|null $limit = null, string|null $pagination_key = null, string|null $before = null): Request
    {
        $options = $this->getClientOptions();
        if ($request_id !== null) {
            $options['query']['request_id'] = ObjectSerializer::toQueryValue($request_id);
        }
        if ($linked_id !== null) {
            $options['query']['linked_id'] = ObjectSerializer::toQueryValue($linked_id);
        }
        if ($limit !== null) {
            $options['query']['limit'] = ObjectSerializer::toQueryValue($limit, 'int32');
        }
        if ($pagination_key !== null) {
            $options['query']['paginationKey'] = ObjectSerializer::toQueryValue($pagination_key);
        }
        if ($before !== null) {
            $options['query']['before'] = ObjectSerializer::toQueryValue($before, 'int64');
        }
        $url = str_replace("{visitor_id}", $visitor_id, $this->getVisitsURL()) . "?" . http_build_query($options['query']);
        return new Request('GET', $url, $options['headers']);
    }

    public function getVisits(string $visitor_id, string|null $request_id = null, string|null $linked_id = null, string|null $limit = null, string|null $pagination_key = null, string|null $before = null): Response
    {
        $response = $this->client->sendRequest($this->getVisitsRequest($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before));
        $content = $response->getBody()->getContents();
        /** @var Response $serialized */
        $serialized = ObjectSerializer::deserialize($content, Response::class, []);
        $serialized->setRawResponse($content);

        return $serialized;
    }
}
