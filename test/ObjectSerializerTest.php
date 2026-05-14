<?php

namespace Fingerprint\ServerSdk\Test;

use Fingerprint\ServerSdk\Model\Event;
use Fingerprint\ServerSdk\Model\EventUpdate;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ObjectSerializer::class)]
class ObjectSerializerTest extends TestCase
{
    /**
     * @throws \Random\RandomException;
     */
    public function testUpdateEventTagSerialization(): void
    {
        $tag = [
            'automationTest_testName' => 'Automation Test Scenario 1',
            'automationTest_testId' => 'test_'.substr(bin2hex(random_bytes(4)), 0, 6),
            'automationTest_metadata' => [
                'id' => rand(1, 1000),
                'description' => 'This is a metadata description for automation testing.',
                'createdAt' => (new \DateTime())->format(\DateTimeInterface::ATOM),
                'updatedAt' => (new \DateTime())->format(\DateTimeInterface::ATOM),
            ],
            'automationTest_settings' => [
                'retries' => 3,
                'timeout' => 5000,
                'environment' => 'staging',
                'notifications' => ['email', 'slack', 'sms'],
            ],
            'automationTest_users' => [
                ['userId' => '123', 'roles' => ['admin', 'editor'], 'isActive' => true],
                ['userId' => '456', 'roles' => ['viewer'], 'isActive' => false],
            ],
            'automationTest_metrics' => [
                ['name' => 'executionTime', 'value' => 120.5, 'unit' => 'seconds'],
                ['name' => 'memoryUsage', 'value' => 256, 'unit' => 'MB'],
                ['name' => 'assertionsPassed', 'value' => 100],
            ],
            'automationTest_logs' => [
                [
                    'timestamp' => (new \DateTime())->format(\DateTimeInterface::ATOM),
                    'level' => 'info',
                    'message' => 'Test started.',
                ],
                [
                    'timestamp' => (new \DateTime())->format(\DateTimeInterface::ATOM),
                    'level' => 'error',
                    'message' => 'Assertion failed.',
                ],
            ],
        ];

        $body = new EventUpdate();
        $body->setTags($tag);

        $sanitized_body = ObjectSerializer::sanitizeForSerialization($body);
        $this->assertSame($sanitized_body->tags, $tag);
    }

    /**
     * @throws \Exception
     */
    public function testDeserializeValidResponse(): void
    {
        $json = json_decode(file_get_contents(__DIR__.'/mocks/events/get_event_200.json'));

        /** @var Event $result */
        $result = ObjectSerializer::deserialize($json, Event::class);

        $this->assertInstanceOf(Event::class, $result);
        $this->assertNotNull($result->getEventId());
        $this->assertNotNull($result->getIdentification()->getVisitorId());
    }

    public function testSanitizeWithNullPropertiesSkipped(): void
    {
        $body = new EventUpdate();
        $sanitized = ObjectSerializer::sanitizeForSerialization($body);

        $this->assertIsObject($sanitized);
        $vars = get_object_vars($sanitized);
        $this->assertEmpty($vars);
    }

    /**
     * setDateTimeFormat should change the format used when serializing DateTime objects.
     */
    public function testSetDateTimeFormat(): void
    {
        $date = new \DateTime('2025-06-15 10:30:00');

        ObjectSerializer::setDateTimeFormat('Y-m-d');
        $serialized = ObjectSerializer::sanitizeForSerialization($date);
        $this->assertEquals('2025-06-15', $serialized);

        ObjectSerializer::setDateTimeFormat(\DateTimeInterface::ATOM);
        $serialized = ObjectSerializer::sanitizeForSerialization($date);
        $this->assertEquals($date->format(\DateTimeInterface::ATOM), $serialized);
    }

    /**
     * sanitizeFilename should strip directory paths and return only the filename.
     */
    public function testSanitizeFilename(): void
    {
        $this->assertEquals('file.txt', ObjectSerializer::sanitizeFilename('/path/to/file.txt'));
        $this->assertEquals('file.txt', ObjectSerializer::sanitizeFilename('C:\Users\test\file.txt'));
        $this->assertEquals('file.txt', ObjectSerializer::sanitizeFilename('file.txt'));
        $this->assertEquals('file.txt', ObjectSerializer::sanitizeFilename('/file.txt'));
        $this->assertEquals('', ObjectSerializer::sanitizeFilename('/path/to/'));
    }

    /**
     * buildQuery should return an empty string for an empty params array.
     */
    public function testBuildQueryEmpty(): void
    {
        $this->assertSame('', ObjectSerializer::buildQuery([]));
    }

    /**
     * buildQuery should encode simple key-value pairs.
     */
    public function testBuildQuerySimpleParams(): void
    {
        $params = ['key1' => 'value1', 'key2' => 'value2'];

        $this->assertSame('key1=value1&key2=value2', ObjectSerializer::buildQuery($params));
    }

    /**
     * buildQuery should repeat the key for array values.
     */
    public function testBuildQueryArrayValues(): void
    {
        $params = ['tag' => ['a', 'b', 'c']];

        $this->assertSame('tag=a&tag=b&tag=c', ObjectSerializer::buildQuery($params));
    }

    /**
     * buildQuery should encode special characters with RFC 3986 by default.
     */
    public function testBuildQueryEncodesSpecialCharacters(): void
    {
        $params = ['q' => 'a b+c', 'url' => 'https://example.com?a=1'];

        $this->assertSame(
            'q=a%20b%2Bc&url=https%3A%2F%2Fexample.com%3Fa%3D1',
            ObjectSerializer::buildQuery($params)
        );
    }

    /**
     * buildQuery should cast boolean values to 'true' and 'false' strings.
     */
    public function testBuildQueryBooleanValues(): void
    {
        $params = ['active' => true, 'archived' => false];

        $this->assertSame('active=true&archived=false', ObjectSerializer::buildQuery($params));
    }

    /**
     * buildQuery should include the key without a value when the value is null.
     */
    public function testBuildQueryNullValue(): void
    {
        $params = ['key' => null];

        $this->assertSame('key', ObjectSerializer::buildQuery($params));
    }

    /**
     * buildQuery should skip encoding when encoding is set to false.
     */
    public function testBuildQueryNoEncoding(): void
    {
        $params = ['q' => 'a b+c'];

        $this->assertSame('q=a b+c', ObjectSerializer::buildQuery($params, false));
    }

    /**
     * buildQuery should throw InvalidArgumentException for an invalid encoding type.
     */
    public function testBuildQueryInvalidEncoding(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ObjectSerializer::buildQuery(['key' => 'value'], 'invalid');
    }
}
