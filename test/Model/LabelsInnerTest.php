<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\LabelsInner;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(LabelsInner::class)]
class LabelsInnerTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $data = [
            'label' => 'fraud',
            'prediction' => true,
            'ml_score' => 0.85,
        ];
        $model = new LabelsInner($data);

        $this->assertSame('fraud', $model->getLabel());
        $this->assertTrue($model->getPrediction());
        $this->assertSame(0.85, $model->getMlScore());
    }

    public function testSetters(): void
    {
        $model = new LabelsInner();
        $model->setLabel('legit');
        $model->setPrediction(false);
        $model->setMlScore(0.5);

        $this->assertSame('legit', $model->getLabel());
        $this->assertFalse($model->getPrediction());
        $this->assertSame(0.5, $model->getMlScore());
    }

    public function testMlScoreUpperBoundValidation(): void
    {
        $model = new LabelsInner();
        $this->expectException(\InvalidArgumentException::class);
        $model->setMlScore(1.1);
    }

    public function testMlScoreLowerBoundValidation(): void
    {
        $model = new LabelsInner();
        $this->expectException(\InvalidArgumentException::class);
        $model->setMlScore(-0.1);
    }

    public function testMlScoreBoundaryValues(): void
    {
        $model = new LabelsInner();
        $model->setMlScore(0.0);
        $this->assertSame(0.0, $model->getMlScore());

        $model->setMlScore(1.0);
        $this->assertSame(1.0, $model->getMlScore());
    }

    public function testListInvalidPropertiesWhenLabelNull(): void
    {
        $model = new LabelsInner();
        $invalid = $model->listInvalidProperties();
        $this->assertContains("'label' can't be null", $invalid);
        $this->assertFalse($model->valid());
    }

    public function testListInvalidPropertiesWhenMlScoreOutOfRange(): void
    {
        $model = new LabelsInner(['label' => 'test', 'ml_score' => 1.5]);
        $invalid = $model->listInvalidProperties();
        $this->assertNotEmpty($invalid);
    }

    public function testValidWhenAllPropertiesSet(): void
    {
        $model = new LabelsInner(['label' => 'test', 'prediction' => true, 'ml_score' => 0.5]);
        $this->assertTrue($model->valid());
        $this->assertEmpty($model->listInvalidProperties());
    }

    public function testModelName(): void
    {
        $model = new LabelsInner();
        $this->assertSame('Labels_inner', $model->getModelName());
    }

    public function testStaticMethods(): void
    {
        $this->assertIsArray(LabelsInner::openAPITypes());
        $this->assertIsArray(LabelsInner::openAPIFormats());
        $this->assertIsArray(LabelsInner::attributeMap());
        $this->assertIsArray(LabelsInner::setters());
        $this->assertIsArray(LabelsInner::getters());
    }

    public function testArrayAccess(): void
    {
        $model = new LabelsInner(['label' => 'test']);

        $this->assertTrue(isset($model['label']));
        $this->assertSame('test', $model['label']);

        $model['prediction'] = true;
        $this->assertTrue($model['prediction']);

        unset($model['prediction']);
        $this->assertNull($model['prediction']);
    }

    public function testArrayAccessWithNullOffset(): void
    {
        $model = new LabelsInner();
        $model[] = 'appended';
        // Just verify it doesn't throw
        $this->assertTrue(true);
    }

    public function testJsonSerialize(): void
    {
        $model = new LabelsInner(['label' => 'fraud', 'prediction' => true, 'ml_score' => 0.9]);
        $json = json_encode($model);
        $decoded = json_decode($json, true);

        $this->assertSame('fraud', $decoded['label']);
        $this->assertTrue($decoded['prediction']);
        $this->assertSame(0.9, $decoded['ml_score']);
    }

    public function testToString(): void
    {
        $model = new LabelsInner(['label' => 'test']);
        $string = (string) $model;
        $this->assertIsString($string);
        $this->assertStringContainsString('test', $string);
    }

    public function testToHeaderValue(): void
    {
        $model = new LabelsInner(['label' => 'test']);
        $this->assertIsString($model->toHeaderValue());
    }

    public function testDeserialization(): void
    {
        $json = json_encode(['label' => 'fraud', 'prediction' => false, 'ml_score' => 0.42]);
        $model = ObjectSerializer::deserialize(json_decode($json), LabelsInner::class);

        $this->assertInstanceOf(LabelsInner::class, $model);
        $this->assertSame('fraud', $model->getLabel());
        $this->assertFalse($model->getPrediction());
        $this->assertSame(0.42, $model->getMlScore());
    }

    public function testIsNullableSetToNull(): void
    {
        $model = new LabelsInner();
        $this->assertFalse($model->isNullableSetToNull('label'));
    }
}
