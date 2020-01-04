<?php

/**
 * Provides a default constuctor that takes an array (if passed) to set rightaway properties values,
 * setting assigning each existing property to the value that has it's name as key.
 */
trait ArrayInitializer
{
    /**
     * Initializes the object with an array, using keys as properties names.
     * This initializer allows setting every field acessible *inside* the object,
     * regardless it's visibility level outside the object.
     * 
     * @param array $Values Names and values of properties to be set
     */
    public function __construct($Values = []) {
        if (is_array($Values)) foreach ($Values as $Property => $Value) {
            // Avoiding creation of new properties
            if(property_exists($this, $Property)) {
                $this->{$Property} = $Value;
            }
        }
    }
}



/**
 * Provides a default constuctor that takes another object (if passed) to set rightaway the properties of this object,
 * copying all values of visible properties that exist in this object.
 */
trait ObjectInitializer
{
    /**
     * Initializes this object with another object's properties values, using all visible properties of given $Values
     * object.
     * 
     * @param object $Values Another object with *visible* properties to copy here.
     */
    public function __construct($Values = null) {
        if (is_object($Values)) foreach ($Values as $Property => $Value) {
            // Avoiding creation of new properties
            if(property_exists($this, $Property)) {
                $this->{$Property} = $Value;
            }
        }
    }
}
