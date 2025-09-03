<?php

namespace Fingerprint\ServerAPI;

use Fingerprint\ServerAPI\Api\FingerprintApi;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionMethod;

class UtilsTest extends TestCase
{
    private FingerprintApi $fingerprintApi;
    private ReflectionMethod $buildQueryMethod;

    /**
     * Sets up the test environment by creating an instance of the Utils class
     * and making the protected buildQuery method accessible via reflection.
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->fingerprintApi = new FingerprintApi();

        $this->buildQueryMethod = new ReflectionMethod(FingerprintApi::class, 'buildQuery');
        $this->buildQueryMethod->setAccessible(true);
    }

    /**
     * Tests the buildQuery method with various inputs.
     *
     * @dataProvider queryProvider
     * @param array $params The input parameters for the query.
     * @param string $expectedQuery The expected URL-encoded query string.
     * @throws ReflectionException
     */
    public function testBuildQuery(array $params, string $expectedQuery): void
    {
        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expectedQuery, $result);
    }

    /**
     * Provides test cases for the buildQuery method.
     * @return array<string, array{params: array, expected: string}>
     */
    public static function queryProvider(): array
    {
        return [
            'standard case: simple numeric-indexed array' => [
                'params' => ['environments' => ['env1', 'env2']],
                'expected' => 'environments%5B%5D=env1&environments%5B%5D=env2',
            ],
            'standard case: simple associative array' => [
                'params' => ['key1' => 'value1', 'key2' => 'value2'],
                'expected' => 'key1=value1&key2=value2',
            ],
            'standard case: nested associative array (should not be modified)' => [
                'params' => ['user' => ['id' => 123, 'name' => 'John Doe']],
                'expected' => 'user%5Bid%5D=123&user%5Bname%5D=John%20Doe',
            ],
            'standard case: mixed nested array' => [
                'params' => [
                    'filter' => [
                        'type' => 'event',
                        'ids' => [101, 202, 303],
                    ],
                    'sort' => 'desc',
                ],
                'expected' => 'filter%5Btype%5D=event&filter%5Bids%5D%5B%5D=101&filter%5Bids%5D%5B%5D=202&filter%5Bids%5D%5B%5D=303&sort=desc',
            ],
            'edge case: empty array' => [
                'params' => [],
                'expected' => '',
            ],
            'edge case: array with multi-digit numeric indices' => [
                'params' => ['items' => [5 => 'item5', 15 => 'item15']],
                'expected' => 'items%5B%5D=item5&items%5B%5D=item15',
            ],
            'edge case: deeply nested numeric arrays' => [
                'params' => ['data' => [['a', 'b'], ['c']]],
                'expected' => 'data%5B%5D%5B0%5D=a&data%5B%5D%5B1%5D=b&data%5B%5D%5B0%5D=c',
            ],
            'edge case: values with special characters needing encoding' => [
                'params' => ['q' => 'a b+c', 'redirect' => 'https://example.com?a=1&b=2'],
                'expected' => 'q=a%20b%2Bc&redirect=https%3A%2F%2Fexample.com%3Fa%3D1%26b%3D2',
            ],
            'edge case: string key that looks like a numeric index syntax' => [
                // The method should replace this, as the regex matches the URL-encoded form.
                'params' => ['key[0]' => 'value'],
                'expected' => 'key%5B%5D=value',
            ],
            'edge case: boolean and null values' => [
                // http_build_query converts true to 1, false to 0, null to an empty string,
                // and omits top-level keys with null values.
                'params' => ['active' => true, 'archived' => false, 'notes' => null, 'nested' => ['field' => null]],
                'expected' => 'active=1&archived=0&nested%5Bfield%5D=',
            ],
        ];
    }
}