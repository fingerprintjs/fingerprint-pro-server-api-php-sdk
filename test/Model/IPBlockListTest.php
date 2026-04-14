<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\IPBlockList;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(IPBlockList::class)]
class IPBlockListTest extends TestCase
{
    private const EXAMPLE = [
        'email_spam' => true,
        'attack_source' => false,
        'tor_node' => true,
    ];

    /**
     * Constructor without arguments should initialize all properties to null.
     */
    public function testConstructorDefaults(): void
    {
        $model = new IPBlockList();

        $this->assertNull($model->getEmailSpam());
        $this->assertNull($model->getAttackSource());
        $this->assertNull($model->getTorNode());
    }

    /**
     * Constructor should accept an array and populate the properties.
     */
    public function testConstructorWithData(): void
    {
        $model = new IPBlockList(self::EXAMPLE);

        $this->assertEquals(self::EXAMPLE['email_spam'], $model->getEmailSpam());
        $this->assertEquals(self::EXAMPLE['attack_source'], $model->getAttackSource());
        $this->assertEquals(self::EXAMPLE['tor_node'], $model->getTorNode());
    }

    /**
     * Setters should return the model instance for chaining.
     */
    public function testSettersReturnSelf(): void
    {
        $model = new IPBlockList();

        $this->assertSame($model, $model->setEmailSpam(self::EXAMPLE['email_spam']));
        $this->assertSame($model, $model->setAttackSource(self::EXAMPLE['attack_source']));
        $this->assertSame($model, $model->setTorNode(self::EXAMPLE['tor_node']));
    }

    /**
     * Serialization should preserve all property values through a round-trip.
     *
     * @throws \DateMalformedStringException
     */
    public function testSerialization(): void
    {
        $model = new IPBlockList(self::EXAMPLE);

        $json = json_encode(ObjectSerializer::sanitizeForSerialization($model));
        $deserialized = ObjectSerializer::deserialize(json_decode($json), IPBlockList::class);

        $this->assertEquals($model->getEmailSpam(), $deserialized->getEmailSpam());
        $this->assertEquals($model->getAttackSource(), $deserialized->getAttackSource());
        $this->assertEquals($model->getTorNode(), $deserialized->getTorNode());
    }

    /**
     * ArrayAccess interface should allow bracket notation for getting and setting properties.
     *
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function testArrayAccess(): void
    {
        $model = new IPBlockList();

        $model['email_spam'] = self::EXAMPLE['email_spam'];
        $this->assertEquals(self::EXAMPLE['email_spam'], $model['email_spam']);
        $this->assertTrue(isset($model['email_spam']));

        unset($model['email_spam']);
        $this->assertNull($model['email_spam']);
    }

    /**
     * An empty model should be valid since IPBlockList has no required properties.
     */
    public function testValidation(): void
    {
        $emptyModel = new IPBlockList();
        $this->assertTrue($emptyModel->valid());
        $this->assertEmpty($emptyModel->listInvalidProperties());

        $populatedModel = new IPBlockList(self::EXAMPLE);
        $this->assertTrue($populatedModel->valid());
        $this->assertEmpty($populatedModel->listInvalidProperties());
    }

    /**
     * __toString should return a pretty-printed JSON representation.
     */
    public function testToString(): void
    {
        $model = new IPBlockList(self::EXAMPLE);
        $string = (string) $model;

        $decoded = json_decode($string, true);
        $this->assertTrue($decoded['email_spam']);
        $this->assertFalse($decoded['attack_source']);
        $this->assertTrue($decoded['tor_node']);
    }

    /**
     * getModelName should return the OpenAPI model name.
     */
    public function testGetModelName(): void
    {
        $model = new IPBlockList();

        $this->assertEquals('IPBlockList', $model->getModelName());
    }

    /**
     * offsetSet with null offset should append the value to the container.
     */
    public function testOffsetSetWithNullKey(): void
    {
        $model = new IPBlockList();

        $model[] = 'appended_value';
        $this->assertEquals('appended_value', $model[0]);
    }

    /**
     * jsonSerialize should return the sanitized representation used by json_encode.
     */
    public function testJsonSerialize(): void
    {
        $model = new IPBlockList(self::EXAMPLE);
        $serialized = $model->jsonSerialize();

        $this->assertIsObject($serialized);
        $this->assertTrue($serialized->email_spam);
        $this->assertFalse($serialized->attack_source);
    }

    /**
     * toHeaderValue should return a compact JSON string.
     */
    public function testToHeaderValue(): void
    {
        $model = new IPBlockList(self::EXAMPLE);
        $header = $model->toHeaderValue();

        $decoded = json_decode($header, true);
        $this->assertIsArray($decoded);
        $this->assertTrue($decoded['email_spam']);
        $this->assertStringNotContainsString("\n", $header);
    }

    /**
     * isNullableSetToNull should return false for non-nullable fields.
     */
    public function testIsNullableSetToNull(): void
    {
        $model = new IPBlockList(self::EXAMPLE);

        $this->assertFalse($model->isNullableSetToNull('email_spam'));
        $this->assertFalse($model->isNullableSetToNull('tor_node'));
    }

    /**
     * Constructor with null value for a non-nullable field should still store null (default path of setIfExists).
     */
    public function testSetIfExistsWithNullOnNonNullableField(): void
    {
        $data = self::EXAMPLE;
        $data['email_spam'] = null;

        $model = new IPBlockList($data);

        $this->assertNull($model->getEmailSpam());
        $this->assertFalse($model->isNullableSetToNull('email_spam'));
    }
}
