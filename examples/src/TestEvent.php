<?php
namespace Evaneos\Events\Example;

use Evaneos\Events\Event;

class TestEvent implements Event {
    
    /** 
     * @var string
     */
    private $value;
        public function __construct($value) {
        $this->value = $value;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Evaneos\Events\Event::getCategory()
     */
    public function getCategory() {
        return 'test.simple';
    }

    /**
     * Getter for the value
     * 
     * @return string
     */
    public function getValue ()
    {
        return $this->value;
    }
}