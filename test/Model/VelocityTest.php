<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\Velocity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Velocity::class)]
class VelocityTest extends TestCase
{
    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new Velocity();

        $this->assertNull($model->getDistinctIp());
        $this->assertNull($model->getDistinctLinkedId());
        $this->assertNull($model->getDistinctCountry());
        $this->assertNull($model->getEvents());
        $this->assertNull($model->getIpEvents());
        $this->assertNull($model->getDistinctIpByLinkedId());
        $this->assertNull($model->getDistinctVisitorIdByLinkedId());
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new Velocity();

        $this->assertEquals('Velocity', $model->getModelName());
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new Velocity();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a valid JSON representation.
     */
    public function testToString(): void
    {
        $model = new Velocity();
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertIsArray($decoded);
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new Velocity();

        $model['distinct_ip'] = 'test_value';
        $this->assertEquals('test_value', $model['distinct_ip']);
        $this->assertTrue(isset($model['distinct_ip']));

        unset($model['distinct_ip']);
        $this->assertNull($model['distinct_ip']);
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new Velocity();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new Velocity();
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new Velocity();
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertStringNotContainsString("\n", $header);
    }
}
