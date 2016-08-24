<?php namespace Xdire\Collections;

class Stack {

    /** @var object[] | string[] | int[] | mixed[] */
    private $stack = [];
    /** @var int */
    private $length = 0;

    /**
     * Push mixed value to the Stack
     *
     * @param object | string | int | mixed $value
     */
    public function push($value) {
        $this->stack[$this->length]=$value;
        $this->length++;
    }

    /**
     * Pop mixed value from the Stack
     *
     * @return int | mixed | object | string
     */
    public function pop() {
        $value = $this->stack[--$this->length];
        return $value;
    }

    /**
     * Take value from the Stack but left Stack intact
     *
     * @return int | mixed | object | string
     */
    public function peek() {
        return $this->stack[$this->length-1];
    }

    /**
     * Get size of the Stack
     *
     * @return int
     */
    public function size() {
        return $this->length;
    }

    /**
     * Reset stack to starting position
     *
     * fast but doesn't free any resources
     * good for small stacks where memory
     * isn't crucial parameter
     *
     * @return void
     */
    public function reset() {
        $this->length = 0;
    }

    /**
     * Truncate stack and reset it to starting position
     *
     * Will reset every cell in stack and free it's resources
     * for garbage collector.
     *
     * Good for big stacks which need to be fully truncated to
     * release memory recources.
     *
     * @return void
     */
    public function truncate() {

        $this->length--;
        while ($this->length >= 0) {
            $this->stack[$this->length--] = null;
        }

    }

}