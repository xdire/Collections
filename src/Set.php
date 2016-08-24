<?php namespace Xdire\Collections;

/**
 * Collection SET
 * ----------------------------------
 * Set of distinct items
 * Wrapper on default PHP Hash table
 * ----------------------------------
 *
 * Class Set
 * @package Collections
 */
class Set implements \IteratorAggregate
{
    /** @var array */
    private $a;
    /** @var int */
    private $length;

    /**
     * Set constructor.
     */
    public function __construct() {
        $this->a = [];
        $this->length = 0;
    }

    /**
     * @return int
     */
    public function size() {
        return $this->length;
    }

    /**
     * @param $key
     */
    public function add($key) {
        $this->a[$key] = true;
        $this->length++;
    }

    /**
     * @param $key
     */
    public function delete($key) {
        if(isset($this->a[$key])) {
            $this->a[$key] = null;
            $this->length--;
        }
    }

    /**
     * @param string | int | mixed $key
     * @return bool
     */
    public function isInSet($key) {
        return (isset($this->a[$key]));
    }

    /**
     * @param mixed[] $array
     */
    public function fromArray(Array $array) {
        foreach($array as $key => $val) {
            $this->add($key);
        }
    }

    /**
     * @param mixed[] $array
     */
    public function fromArrayValues(Array $array) {
        foreach($array as $key => $val) {
            $this->add($val);
        }
    }

    /**
     * @return array
     */
    public function asArray() {
        return $this->a;
    }

    /**
     * Iterate over keys through forEach
     *
     * @return \Generator
     */
    public function getIterator()
    {
        foreach ($this->a as $k => $v) {
            yield $k;
        }
    }

    /**
     *  Return string representation of Set
     *
     * @return string
     */
    public function toString() {

        $string = "";
        foreach ($this->a as $k=>$v){
            $string .= $k.',';
        }
        return rtrim($string,',');

    }

    /**
     * Retrieve all keys which exists in Set
     *
     * @return mixed
     */
    public function keys() {
        return array_keys($this->a);
    }

    /**
     * Check equality against other list
     *
     * @param Set $s
     * @return bool
     */
    public function equals(Set $s) {

        foreach ($this->a as $k=>$v){
            if(!$s->isInSet($k))
                return false;
        }
        return true;

    }

}