<?php
namespace NaiveDataStructures\Tests;

use tunalaruan\NaiveDataStructures\Set as Set;

class SetTest extends \PHPUnit_Framework_TestCase
{
    protected $set;
    protected $values;

    public function setup()
    {
        $this->set = new Set("boom", "baam", "preee");
        $this->values = ["boom", "baam", "preee"];
    }

    public function testConstruct() 
    {
        $setA = new Set(1,2,3,4,5);
        $this->assertEquals($setA->getType(), 'integer');
        try {
            $set = new Set(1, 'yes');;
        } catch (\InvalidArgumentException $iae) {
            if($iae->getMessage() !== Set::TYPE_ERROR)
                throw new \Exception('Incorrect exception thrown');
            else
                return;
        }
        $this->fail('Expected invalid argument exception not thrown');
    }

    public function testCheckType()
    {
        $this->assertFalse($this->set->checkType(0));
        $this->assertTrue($this->set->checkType("aaaa"));
    }

    public function testGetType()
    {
        $this->assertEquals("string", $this->set->getType());
    }

    public function testCount()
    {
        $this->assertEquals(3, count($this->set));
    }

    public function testIteration()
    {
        foreach($this->set as $key=>$val) {
            $this->assertEquals($val, $this->values[$key]);
        }
    }

    public function testGetContent()
    {
        $this->assertEquals($this->set->getContent(), $this->values);
    }

    public function testUnion()
    {
        $setB = new Set("derp", "durr", "boom");
        $setUnion = $setB->union($this->set);
        $this->assertEquals(["derp", "durr", "boom", "baam", "preee"],
            $setUnion->getContent());
    }

}

