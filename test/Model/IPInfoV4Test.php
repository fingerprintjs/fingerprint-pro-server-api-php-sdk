<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\IPInfoV4;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(IPInfoV4::class)]
class IPInfoV4Test extends TestCase
{
    private const EXAMPLE = [
        'address' => '192.168.1.1',
        'asn' => 'AS15169',
        'asn_name' => 'Google',
        'asn_network' => '192.168.0.0/16',
        'asn_type' => 'isp',
        'datacenter_result' => false,
        'datacenter_name' => 'Google Cloud',
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new IPInfoV4();

        $this->assertNull($model->getAddress());
        $this->assertNull($model->getGeolocation());
        $this->assertNull($model->getAsn());
        $this->assertNull($model->getAsnName());
        $this->assertNull($model->getAsnNetwork());
        $this->assertNull($model->getAsnType());
        $this->assertNull($model->getDatacenterResult());
        $this->assertNull($model->getDatacenterName());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new IPInfoV4(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['address'], $model->getAddress());
        $this->assertEquals(self::EXAMPLE['asn'], $model->getAsn());
        $this->assertEquals(self::EXAMPLE['asn_name'], $model->getAsnName());
        $this->assertEquals(self::EXAMPLE['asn_network'], $model->getAsnNetwork());
        $this->assertEquals(self::EXAMPLE['asn_type'], $model->getAsnType());
        $this->assertEquals(self::EXAMPLE['datacenter_result'], $model->getDatacenterResult());
        $this->assertEquals(self::EXAMPLE['datacenter_name'], $model->getDatacenterName());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new IPInfoV4();

        $this->assertSame($model, $model->setAddress(self::EXAMPLE['address']));
        $this->assertSame($model, $model->setAsn(self::EXAMPLE['asn']));
        $this->assertSame($model, $model->setAsnName(self::EXAMPLE['asn_name']));
        $this->assertSame($model, $model->setAsnNetwork(self::EXAMPLE['asn_network']));
        $this->assertSame($model, $model->setAsnType(self::EXAMPLE['asn_type']));
        $this->assertSame($model, $model->setDatacenterResult(self::EXAMPLE['datacenter_result']));
        $this->assertSame($model, $model->setDatacenterName(self::EXAMPLE['datacenter_name']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new IPInfoV4(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), IPInfoV4::class);

        $this->assertEquals($model->getAddress(), $deserialized->getAddress());
        $this->assertEquals($model->getAsn(), $deserialized->getAsn());
        $this->assertEquals($model->getAsnName(), $deserialized->getAsnName());
        $this->assertEquals($model->getAsnNetwork(), $deserialized->getAsnNetwork());
        $this->assertEquals($model->getAsnType(), $deserialized->getAsnType());
        $this->assertEquals($model->getDatacenterResult(), $deserialized->getDatacenterResult());
        $this->assertEquals($model->getDatacenterName(), $deserialized->getDatacenterName());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new IPInfoV4();

        $model['address'] = self::EXAMPLE['address'];
        $this->assertEquals(self::EXAMPLE['address'], $model['address']);
        $this->assertTrue(isset($model['address']));

        unset($model['address']);
        $this->assertNull($model['address']);
    }

    /**
     * A fully populated model should be valid; a default-constructed model should not because address is required.
     */
    public function testValidation(): void
    {
        $emptyModel = new IPInfoV4();
        $this->assertFalse($emptyModel->valid());
        $this->assertNotEmpty($emptyModel->listInvalidProperties());

        $validModel = new IPInfoV4(self::EXAMPLE);
        $this->assertTrue($validModel->valid());
        $this->assertEmpty($validModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new IPInfoV4(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['address'], $decoded['address']);
        $this->assertEquals(self::EXAMPLE['asn'], $decoded['asn']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new IPInfoV4();

        $this->assertEquals('IPInfoV4', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new IPInfoV4();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new IPInfoV4(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['address'], $serialized->address);
        $this->assertEquals(self::EXAMPLE['asn'], $serialized->asn);
    }

    /**
     * toHeaderValue should return a compact JSON string without newlines.
     */
    public function testToHeaderValue(): void
    {
        $model = new IPInfoV4(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['address'], $decoded['address']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
