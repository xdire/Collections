<?php

class SetTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        require_once ("../vendor/autoload.php");
    }

    public function sampleNumbersData() {
        return [
            [
                [1,1,2,2,3,4,5,6,6,6,7,8,9,10,10]
            ]
        ];
    }

    public function sampleStringsData() {
        return [
            [
                ["one","one","one","two","two","two","three","three","three","four","four","four","five","five","five"]
            ]
        ];
    }

    /**
     * @dataProvider sampleStringsData
     */
    public function testSetFillUp() {



    }

    public function testSetDelete() {



    }

    public function testSetExists() {



    }

    /**
     * @dataProvider sampleNumbersData
     * @param array $data
     */
    public function testSetIteration(array $data) {

        $set = new \Xdire\Collections\Set();
        $set->fromArrayValues($data);

        foreach ($set as $val) {
            $this->assertEquals(true,$set->isInSet($val));
        }

    }

}
