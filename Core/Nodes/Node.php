<?php
/**
 * Created by Anton Repin.
 * Date: 14.10.15
 * Time: 17:30
 */

namespace Core\Nodes;

class Node
{
    /** @var mixed | null */
    public $key=null;
    /** @var mixed | null */
    public $value=null;
    /** @var Node | null */
    public $next=null;
    /** @var Node | null */
    public $prev=null;

    /**
     * Node constructor.
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }


}