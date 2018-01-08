<?php

namespace D946\Test;

use PHPUnit\Framework\TestCase;
use D946\Brackets;

class BracketsTest extends TestCase
{

    private function getDataOfInstance($input)
    {
        $brackets = new Brackets();
        $brackets->load($input);
        return $brackets->verify();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExpressions($input, $expected)
    {
        $result = $this->getDataOfInstance($input);
        $this->assertEquals($expected, $result);
    }
    public function dataProvider()
    {
        return [
            [" () ", true],
            [")(", false],
            ["\t(\r()()\n)(((())))", true],
            ["())(()", false],
            ["\t\r\n", true],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldRaseException_With_EmptyData()
    {
        $this->getDataOfInstance("");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldRaseException_With_InvalidData()
    {
        $this->getDataOfInstance("( 12 + 5 )");
    }

}
