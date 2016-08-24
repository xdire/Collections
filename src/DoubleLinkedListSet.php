<?php namespace Xdire\Collections;

use Xdire\Collections\SubTypes\KeyValueNode;
use Xdire\Collections\SubTypes\Node;

/**
 *  ----------------------------------------------
 *  Double Linked List Set
 *  ----------------------------------------------
 *
 *  Main purpose for this type Collection
 *  of items ordered :
 *
 *  - min to max by value
 *  - max to min by value
 *
 *  while maintaining distinct or not distinct keys
 *  while keeping order by values
 *
 *  Iteration possible on:
 *  - min to max by touching Node->next != null
 *  - max to min by touching Node->prev != null
 *
 * Class DoubleLinkedListSet
 * @package Core\Collections
 */
class DoubleLinkedListSet implements \Iterator
{
    /** @var Node | null */
    private $root = null;
    /** @var Node | null */
    private $min = null;
    /** @var Node | null */
    private $max  =null;
    /** @var Node | null */
    private $current = null;

    private $index = [];

    private $count = 0;
    /** @var Node | null */
    private $iteration = null;

    /**
     * @param string | int | mixed $key
     * @param string | int | mixed $value
     */
    public function add($key, $value) {

        if($this->root === null) {

            $node = new Node($key, $value);

            $this->root = $node;
            $this->current = $node;
            $this->min = $node;
            $this->max = $node;
            $this->_setToIndex($key, $node);
            $this->count++;

            return;

        }
        // ********************************
        // ----------- Go right -----------
        // ********************************
        if($value > $this->root->value) {

            $node = $this->root;

            while($node !== null) {

                # Move to the right until:
                // -   reach null value
                // -   or value greater than $value which means that we can add to the left
                if($node->next !== null && $value >= $node->value)
                {
                    $node = $node->next;
                    continue;
                }

                // Add node to the left of current node
                if($value < $node->value) {

                    $newnode = new Node($key, $value);
                    $prev = $node->prev;               // take left part of current node
                    $prev->next = $newnode;            // put new node in the node to the left
                    $newnode->next = $node;             // new node: set current node as next
                    $newnode->prev = $prev;             // new node: set node on the left as prev
                    $node->prev = $newnode;             // set new node to the left of current node
                    $this->_setToIndex($key, $newnode);
                    $this->count++;
                    break;

                }

                // Add node to the right of current node
                $newnode = new Node($key, $value);
                $newnode->prev = $node;                 // new node: set lesser node as previous

                if($node->next !== null)
                    $newnode->next = $node->next;      // new node: set next to prev node next element (if not null)
                else
                    $this->max = $newnode;             // set new max if it's the lat node to the right

                $node->next = $newnode;                // set current node next to new node

                // Count nodes
                $this->count++;
                $this->_setToIndex($key, $newnode);
                break;

            }

        }
        // ******************************
        // ---------- Go left -----------
        // ******************************
        else {

            $node = $this->root;

            while($node !== null){

                # Move to the left until reach null or value that lesser than $value
                if($node->prev !== null && $value <= $node->value)
                {
                    $node = $node->prev;
                    continue;
                }

                // Add node to the right of current node if it's node somewhere in between
                if($value > $node->value) {

                    $newnode = new Node($key, $value);
                    $next = $node->next;               // take right part of current node
                    $next->prev = $newnode;            // put new node in the node (prev param) to the right
                    $newnode->prev = $node;             // new node: set current node as previous
                    $newnode->next = $next;             // new node: set node on the right as next
                    $node->next = $newnode;             // set new node to the right of current node
                    $this->_setToIndex($key, $newnode);
                    $this->count++;
                    break;                              // exit

                }

                // Add node to the left of current node
                $newnode = new Node($key, $value);
                $newnode->next = $node;                 // new node: set greater node as next node

                if($node->prev !== null)
                    $newnode->prev = $node->prev;      // new node: set prev to prev node of current element (if not null)
                else
                    $this->min = $newnode;             // set new min if it's the last node to the left

                $node->prev = $newnode;                // set current node prev pointer to new node

                $this->count++;                         // add count
                $this->_setToIndex($key, $newnode);

                break;

            }

        }

    }

    /**
     * Store Pointer to One of the Keys (if Keys are not distinct)
     * @param mixed $key
     * @param Node $node
     */
    private function _setToIndex($key, $node) {
        $this->index[$key] = $node;
    }

    /**
     * @return bool
     */
    public function isEmpty() {
        return $this->count < 1;
    }

    /**
     * @return int
     */
    public function size() {
        return $this->count;
    }

    /**
     *  @param mixed $key
     *  @return Node | null
     */
    public function getKey($key) {
        if(isset($this->index[$key])) {
            $node = &$this->index[$key];
            return $node;
        }
        return null;
    }

    /**
     * Change Structure Root
     * @param void
     */
    private function _chRoot() {

        if($this->root->prev !== null) {
            $node = $this->root->prev;
            $this->root = $node;
        }
        elseif($this->root->next !== null) {
            $node = $this->root->next;
            $this->root = $node;
        } else {
            $this->root = null;
        }

    }

    /**
     *  @param $key
     *  @return Node | |null
     */
    public function popKey($key) {

        if(isset($this->index[$key])) {

            $node = &$this->index[$key];

            if($node === $this->root) {
                $this->_chRoot();
            }

            $this->_delete($node);
            $this->index[$key] = null;

            return $node;

        }

        return null;

    }

    /**
     *  @return Node|null
     */
    public function popMax() {

        if(!$this->isEmpty()) {

            $node = $this->max;

            $prev = $node->prev;
            if($prev !== null)
                $prev->next = null;
            $this->max = $prev;

            if ($node === $this->root) {
                $this->_chRoot();
            }

            return $node;
        }

        return null;

    }

    /**
     *  @return Node | null
     */
    public function popMin() {

        if(!$this->isEmpty()) {

            $node = $this->min;
            $next = $node->next;
            if($node->next != null)
                $next->prev = null;
            $this->min = $next;

            if ($node === $this->root) {
                $this->_chRoot();
            }

            return $node;

        }
        return null;

    }

    /**
     *  @param Node $node
     */
    private function _delete(Node &$node) {

        if($node->next !== null && $node->prev !== null) {
            $next = $node->next;
            $prev = $node->prev;
            $prev->next = $next;
            $next->prev = $prev;
        } elseif($node->next !== null) {
            $this->popMin();
        } elseif($node->prev !== null) {
            $this->popMax();
        }

    }

    /**
     *  @param mixed $value
     *  @return array | null
     */
    public function lesserThan($value) {

        if(!$this->isEmpty()) {

            $a = [];
            $count=0;
            $node = $this->root;

            if ($value > $node->value) {

                while($node !== null) {
                    if($value <= $node->value) {
                        break;  // Break on equal or greater case
                    }
                    $node = $node->next;
                }

            }

            // Return array of data
            if($value < $node->value) {

                while($node !== null) {
                    if($value < $node->value) {
                        $a[$node->key] = $node;
                        $count++;
                    }
                    $node = $node->prev;
                }

            }

            if($count > 0) {
                return $a;
            }

        }

        return null;
    }

    /**
     *  @param mixed $value
     *  @return array | null
     */
    public function greaterThan($value) {

        if(!$this->isEmpty()) {

            $a = [];
            $count=0;
            $node = $this->root;

            // Case if values are to the left
            // Go down by the count if value to the left of root
            // If pointer found then set node to pointer and move to next
            if ($value < $node->value) {

                while($node !== null) {
                    if($value >= $node->value) {
                        break;  // Break on equal or greater case
                    }
                    $node = $node->prev;
                }

            }

            // Return array of data
            if($value > $node->value) {

                while($node !== null) {
                    if($value > $node->value) {
                        $a[$node->key] = $node;
                        $count++;
                    }
                    $node = $node->next;
                }

            }

            if($count > 0) {
                return $a;
            }

        }

        return null;

    }

    /**
     *  Return non distinct Array of Keys sorted Min to Max
     *
     *  @return array
     */
    public function toArrayMinMax() {

        if(!$this->isEmpty()) {

            $node = $this->min;
            $a = [];
            $count=0;

            while ($node !== null) {
                $a[$count++] = $node->toKeyValueNode();
                $node = $node->next;
            }

            return $a;

        }

        return null;

    }

    /**
     *  Return non distinct Array of Keys sorted Min to Max
     *
     *  @return array
     */
    public function toArrayMaxMin() {

        if(!$this->isEmpty()) {

            $node = $this->max;
            $a = [];
            $count=0;

            while ($node !== null) {
                $a[$count++] = $node->toKeyValueNode();
                $node = $node->prev;
            }

            return $a;
        }

        return null;

    }

    /**
     *  Return distinct Array of Keys sorted Min to Max
     *
     *  @return array
     */
    public function toDistinctArrayMinMax() {

        if(!$this->isEmpty()) {

            $node = $this->min;
            $a = [];

            while ($node !== null) {
                $a[$node->key] = $node->value;
                $node = $node->next;
            }

            return $a;

        }

        return null;

    }

    /**
     *  Return distinct Array of Keys sorted Max to Min
     *
     *  @return array
     */
    public function toDistinctArrayMaxMin() {

        if(!$this->isEmpty()) {

            $node = $this->max;
            $a = [];

            while ($node !== null) {
                $a[$node->key] = $node->value;
                $node = $node->prev;
            }

            return $a;

        }

        return null;

    }

    /**
     * @return KeyValueNode
     */
    public function current() {
        if($this->iteration === null){
            $this->iteration = $this->min;
        }
        return $this->iteration->toKeyValueNode();
    }

    /**
     * @return null|Node
     */
    public function next() {
        return $this->iteration = $this->iteration->next;
    }

    /**
     * @return int|mixed|null|string
     */
    public function key() {
        if($this->iteration !== null){
            return $this->iteration->key;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function valid() {
        return $this->iteration !== null;
    }

    /**
     * @return void
     */
    public function rewind() {
        $this->iteration = $this->min;
    }

}