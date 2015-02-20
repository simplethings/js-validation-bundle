<?php

namespace SimpleThings\JsValidationBundle\Tests\Services;

use SimpleThings\JsValidationBundle\ConstraintsGenerator;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;

class ConstraintsGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConstraintsGenerator
     */
    private $generator;

    /**
     * @var MetadataFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $metadataFactory;

    public function setUp()
    {
        $this->metadataFactory = $this->getMock('Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface');
        $this->generator = new ConstraintsGenerator($this->metadataFactory);
    }

    public function testGenerateEmpty()
    {
        $this->assertEquals("[]", $this->generator->generate(array()));
    }

    public function testGenerate()
    {
        $constraint = new Range(array('min' => 10));

        $cm = new ClassMetadata(__NAMESPACE__ . '\TestEntity');
        $cm->addPropertyConstraint('field1', $constraint);
        $this->metadataFactory->expects($this->once())->method('getMetadataFor')->will($this->returnValue($cm));

        $data = $this->generator->generate(array(__NAMESPACE__ . '\TestEntity'));
        $this->assertEquals('{"SimpleThings\\\\JsValidationBundle\\\\Tests\\\\Services\\\\TestEntity":{"field1":{"range":{"minMessage":"This value should be {{ limit }} or more.","maxMessage":"This value should be {{ limit }} or less.","invalidMessage":"This value should be a valid number.","min":10,"max":null,"payload":null,"groups":["Default","TestEntity"]}}}}', $data);
    }

    public function testGenerateClass()
    {
        $constraint = new Range(array('min' => 10));

        $cm = new ClassMetadata(__NAMESPACE__ . '\TestEntity');
        $cm->addPropertyConstraint('field1', $constraint);
        $this->metadataFactory->expects($this->once())->method('getMetadataFor')->will($this->returnValue($cm));

        $data = $this->generator->generateClass(__NAMESPACE__ . '\TestEntity');

        $this->assertArrayHasKey('field1', $data);
        $this->assertArrayHasKey('range', $data['field1']);
        $this->assertEquals($constraint, $data['field1']['range']);
    }
}

class TestEntity
{
    public $field1;
}

