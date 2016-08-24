<?php
/**
 * Created by Anton Repin.
 * Date: 13.10.15
 * Time: 12:56
 */

namespace Core\Collections;

/**
 * Collection SET
 *
 * Set of items which can be :
 * ---------------------------------
 *
 * - Apples, Couples, Zapples
 * - 1,15,654,453,543,65
 *
 * Class Set
 * @package Collections
 */
class Set implements \Iterator
{

    /**
     * @var array
     */
    private $a;
    /**
     * @var int
     */
    private $c;
    /**
     * Set constructor.
     */
    public function __construct()
    {
        $this->a = array();
        $this->c = 0;
    }

    /**
     * @return int
     */
    public function count(){
        return $this->c;
    }

    /**
     * @param $key
     */
    public function add($key){
        $this->a[$key] = 1;
        $this->c++;
    }

    /**
     * @param $key
     */
    public function delete($key){
        $this->a[$key] = null;
        $this->c--;
    }

    /**
     * @param $key
     * @return bool
     */
    public function isInSet($key){
        return (isset($this->a[$key]));
    }

    /**
     * @param array $array
     */
    public function appendFromArrayKeys(Array $array){
        foreach($array as $key=>$val){
            $this->add($key);
        }
    }

    public function appendFromArrayValues(Array $array){
        foreach($array as $key=>$val){
            $this->add($val);
        }
    }


    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        $var = current($this->a);
        return $var;
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->a);
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        $var = key($this->a);
        return $var;
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return !is_null($this->current());
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->a);
    }


}