<?php
namespace NaiveDataStructures\Tests;

use tunalaruan\NaiveDataStructures\Set as Set;

class SetTest extends \PHPUnit_Framework_TestCase
{
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
}
