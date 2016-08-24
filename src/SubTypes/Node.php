<?php namespace Xdire\Collections\SubTypes;

class Node
{
    /** @var mixed | null */
    public $key = null;
    /** @var mixed | null */
    public $value = null;
    /** @var Node | null */
    public $next = null;
    /** @var Node | null */
    public $prev = null;

    /**
     * Node constructor.
     * @param string | int | mixed $key
     * @param string | int | mixed $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function toKeyValueNode() {
        return new KeyValueNode($this->key, $this->value);
    }

}