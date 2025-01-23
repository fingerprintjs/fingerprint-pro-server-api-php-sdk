<?php

use Fingerprint\ServerAPI\Model\EventsUpdateRequest;
use Fingerprint\ServerAPI\ObjectSerializer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ObjectSerializerTest extends TestCase
{
    public function testUpdateEventTagSerialization()
    {
        $tag = [
            'automationTest_testName' => 'Automation Test Scenario 1',
            'automationTest_testId' => 'test_'.substr(bin2hex(random_bytes(4)), 0, 6),
            'automationTest_metadata' => [
                'id' => rand(1, 1000),
                'description' => 'This is a metadata description for automation testing.',
                'createdAt' => (new DateTime())->format(DateTime::ATOM),
                'updatedAt' => (new DateTime())->format(DateTime::ATOM),
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
                    'timestamp' => (new DateTime())->format(DateTime::ATOM),
                    'level' => 'info',
                    'message' => 'Test started.',
                ],
                [
                    'timestamp' => (new DateTime())->format(DateTime::ATOM),
                    'level' => 'error',
                    'message' => 'Assertion failed.',
                ],
            ],
        ];

        $body = new EventsUpdateRequest();
        $body->setTag($tag);

        $sanitized_body = ObjectSerializer::sanitizeForSerialization($body);
        $this->assertSame($sanitized_body->tag, $tag);
    }
}
