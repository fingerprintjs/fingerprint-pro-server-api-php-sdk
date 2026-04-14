<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\VPNMethods;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(VPNMethods::class)]
class VpnMethodsTest extends TestCase
{
    private const EXAMPLE = [
        'timezone_mismatch' => true,
        'public_vpn' => false,
        'auxiliary_mobile' => false,
        'os_mismatch' => true,
        'relay' => false,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new VPNMethods();

        $this->assertNull($model->getTimezoneMismatch());
        $this->assertNull($model->getPublicVpn());
        $this->assertNull($model->getAuxiliaryMobile());
        $this->assertNull($model->getOsMismatch());
        $this->assertNull($model->getRelay());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new VPNMethods(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['timezone_mismatch'], $model->getTimezoneMismatch());
        $this->assertEquals(self::EXAMPLE['public_vpn'], $model->getPublicVpn());
        $this->assertEquals(self::EXAMPLE['auxiliary_mobile'], $model->getAuxiliaryMobile());
        $this->assertEquals(self::EXAMPLE['os_mismatch'], $model->getOsMismatch());
        $this->assertEquals(self::EXAMPLE['relay'], $model->getRelay());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new VPNMethods();

        $this->assertSame($model, $model->setTimezoneMismatch(self::EXAMPLE['timezone_mismatch']));
        $this->assertSame($model, $model->setPublicVpn(self::EXAMPLE['public_vpn']));
        $this->assertSame($model, $model->setAuxiliaryMobile(self::EXAMPLE['auxiliary_mobile']));
        $this->assertSame($model, $model->setOsMismatch(self::EXAMPLE['os_mismatch']));
        $this->assertSame($model, $model->setRelay(self::EXAMPLE['relay']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new VPNMethods(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), VPNMethods::class);

        $this->assertEquals($model->getTimezoneMismatch(), $deserialized->getTimezoneMismatch());
        $this->assertEquals($model->getPublicVpn(), $deserialized->getPublicVpn());
        $this->assertEquals($model->getAuxiliaryMobile(), $deserialized->getAuxiliaryMobile());
        $this->assertEquals($model->getOsMismatch(), $deserialized->getOsMismatch());
        $this->assertEquals($model->getRelay(), $deserialized->getRelay());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new VPNMethods();

        $model['timezone_mismatch'] = self::EXAMPLE['timezone_mismatch'];
        $this->assertEquals(self::EXAMPLE['timezone_mismatch'], $model['timezone_mismatch']);
        $this->assertTrue(isset($model['timezone_mismatch']));

        unset($model['timezone_mismatch']);
        $this->assertNull($model['timezone_mismatch']);
    }

    /**
     * An empty model should be valid because there are no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new VPNMethods();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new VPNMethods(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertEquals(self::EXAMPLE['timezone_mismatch'], $decoded['timezone_mismatch']);
        $this->assertEquals(self::EXAMPLE['public_vpn'], $decoded['public_vpn']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new VPNMethods();

        $this->assertEquals('VpnMethods', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new VPNMethods();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new VPNMethods(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertEquals(self::EXAMPLE['timezone_mismatch'], $serialized->timezone_mismatch);
        $this->assertEquals(self::EXAMPLE['public_vpn'], $serialized->public_vpn);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new VPNMethods(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertEquals(self::EXAMPLE['timezone_mismatch'], $decoded['timezone_mismatch']);
        $this->assertStringNotContainsString("\n", $header);
    }
}
