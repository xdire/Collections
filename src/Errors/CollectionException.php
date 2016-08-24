<?php namespace Xdire\Collections\Errors;

class CollectionException extends \Exception
{

    /**
     * CollectionException constructor.
     * @param string $message
     * @param int    $code
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
    
}