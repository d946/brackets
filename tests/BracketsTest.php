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

    private function getDataOfInstanceWithAST($input)
    {
        $brackets = new Brackets();
        $brackets->load($input);
        $brackets->verify(true);
        return $brackets->getAST();
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
            ["(", false],
            [")(", false],
            ["\t(\r()()\n)(((())))", true],
            ["())(()", false],
            ["\t\r\n", true],
        ];
    }

    /**
     * @dataProvider dataProviderAST
     */
/*    public function testExpressionsAST($input, $expected)
    {
        $result = $this->getDataOfInstanceWithAST($input);
        $this->assertEquals($expected, $result, "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);
    }*/


    public function dataProviderAST()
    {
        return [
            [" () ", []],
            ["(", []],
            [")(", []],
            ["\t(\r()()\n)(((())))", []],
            ["())(()", []],
            ["\t\r\n", []],
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
