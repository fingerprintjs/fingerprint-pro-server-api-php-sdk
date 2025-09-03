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
     * @throws ReflectionException
     */
    public function testBuildQueryWithSimpleNumericIndexedArray(): void
    {
        $params = ['environments' => ['env1', 'env2']];
        $expected = 'environments%5B%5D=env1&environments%5B%5D=env2';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithSimpleAssociativeArray(): void
    {
        $params = ['key1' => 'value1', 'key2' => 'value2'];
        $expected = 'key1=value1&key2=value2';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithNestedAssociativeArray(): void
    {
        $params = ['user' => ['id' => 123, 'name' => 'John Doe']];
        $expected = 'user%5Bid%5D=123&user%5Bname%5D=John%20Doe';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithMixedNestedArray(): void
    {
        $params = [
            'filter' => [
                'type' => 'event',
                'ids' => [101, 202, 303],
            ],
            'sort' => 'desc',
        ];
        $expected = 'filter%5Btype%5D=event&filter%5Bids%5D%5B%5D=101&filter%5Bids%5D%5B%5D=202&filter%5Bids%5D%5B%5D=303&sort=desc';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithEmptyArray(): void
    {
        $params = [];
        $expected = '';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithMultiDigitNumericIndices(): void
    {
        $params = ['items' => [5 => 'item5', 15 => 'item15']];
        $expected = 'items%5B%5D=item5&items%5B%5D=item15';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithDeeplyNestedNumericArrays(): void
    {
        $params = ['data' => [['a', 'b'], ['c']]];
        $expected = 'data%5B%5D%5B0%5D=a&data%5B%5D%5B1%5D=b&data%5B%5D%5B0%5D=c';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithSpecialCharacters(): void
    {
        $params = ['q' => 'a b+c', 'redirect' => 'https://example.com?a=1&b=2'];
        $expected = 'q=a%20b%2Bc&redirect=https%3A%2F%2Fexample.com%3Fa%3D1%26b%3D2';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithStringKeyLikeNumericIndex(): void
    {
        $params = ['key[0]' => 'value'];
        $expected = 'key%5B%5D=value';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testBuildQueryWithBooleanAndNullValues(): void
    {
        $params = ['active' => true, 'archived' => false, 'notes' => null, 'nested' => ['field' => null]];
        $expected = 'active=1&archived=0&nested%5Bfield%5D=';

        $result = $this->buildQueryMethod->invoke($this->fingerprintApi, $params);
        $this->assertSame($expected, $result);
    }
}