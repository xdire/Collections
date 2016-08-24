<?php

class DoubleLinkedSetTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();
        require_once("../vendor/autoload.php");
    }

    public function sampleNumbersData() {
        return [
            [
                [11,11,22,22,4,3,16,5,6,9,6,8,7,8,9,10,30,-15]
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
     * @dataProvider sampleNumbersData
     * @param array $data
     */
    public function testNumericValuesInsertion(array $data) {

        $doubleSet = new \Xdire\Collections\DoubleLinkedListSet();

        foreach ($data as $k => $v) {
            $doubleSet->add($k,$v);
        }

        asort($data);
        $this->assertEquals($data,$doubleSet->toDistinctArrayMinMax());
        arsort($data);
        $this->assertEquals($data,$doubleSet->toDistinctArrayMaxMin());

    }

    /**
     * @dataProvider sampleStringsData
     * @param array $data
     */
    public function testStringValuesInsertion(array $data) {

        $doubleSet = new \Xdire\Collections\DoubleLinkedListSet();

        foreach ($data as $k => $v) {
            $doubleSet->add($k,$v);
        }

        asort($data);
        $this->assertEquals($data,$doubleSet->toDistinctArrayMinMax());
        arsort($data);
        $this->assertEquals($data,$doubleSet->toDistinctArrayMaxMin());

    }

    /**
     * @dataProvider sampleNumbersData
     * @param array $data
     */
    public function testTraversability(array $data) {

        $doubleSet = new \Xdire\Collections\DoubleLinkedListSet();

        foreach ($data as $k => $v) {
            $doubleSet->add($k,$v);
        }

        foreach ($doubleSet as $d) {
            var_dump($d);
            
        }

    }

}
