<?php

/**
 * Provides a default constuctor that takes an array (if passed) to set rightaway properties values,
 * setting assigning each existing property to the value that has it's name as key.
 */
trait ArrayInitializer {
    /**
     * Initializes the object with an array, using keys as properties names.
     * This initializer allows setting every field acessible *inside* the object,
     * regardless it's visibility level outside the object.
     * 
     * @param array $Values Names and values of properties to be set
     */
    public function __construct(array $Values = []) {
        foreach ($Values as $Property => $Value) {
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
trait ObjectInitializer {
    /**
     * Initializes this object with another object's properties values, using all visible properties of given $Values
     * object.
     * 
     * @param object $Values Another object with *visible* properties to copy here.
     */
    public function __construct(object $Values = null) {
        if ($Values != null) { // Comparison sould be faster than calling is_object()
            foreach ($Values as $Property => $Value) {
                // Avoiding creation of new properties
                if(property_exists($this, $Property)) {
                    $this->{$Property} = $Value;
                }
            }
        }
    }
}




/**
 * Allows to have readonly properties in a class, as long they are not public.
 */
trait ReadOnlyProperties {
    /**
     * White-list of non-pblic fields allowed to be accessed by __get().
     * Ignorered when it's empty (null or empty arrray), always checked otherwise.
     * 
     * @var array|null
     */
    protected static $VisibleFields;

    /**
     * "Magical" getter to access all non-public properties.
     * 
     * @return mixed
     */
    public function __get(string $name) {
        if (empty($VisibleFields)) {
            return property_exists($this, $name) ? $this->$name : null;
        } else {
            return in_array($name, self::$VisibleFields) ? $this->$name : null;
        }
    }
}