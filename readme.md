# PHP-Initializer

Very simple implementation of default constructors that mimic C#'s object initializers in pure PHP code.

> This main repository use parameter type declarations wich require PHP 7.2.0+ to work properly.

## How it works

This lib provides the constructor-initiazer functionality on two different ways, each using a [Trait](https://www.php.net/manual/en/language.oop5.traits.php) with a self-describing name:

* **ArrayInitializer**  
Receives an array, using each value to set an existing property with same name as value's key
* **ObjectInitializer**  
Receives an object, using each of it's visible property to set our existing properties.

As you can notice, both types of initializer check if a property already exists before setting it. This allows to easily use the same Array/Object to set instances of different classes - wich is particularly useful with recordsets.

## Using PHP-Initializer

Just use one of the two traits on your classes, depending on the type of initializer you want to use.

> **Notice**: PHP doesn't support multiple methods with the same name, so using both traits on the same class is not an option.  
Also, Class members override Trait members, so the initializers cannot be used along with custom class constructors.

Here's is a basic demo that I use to test this lib myself:


```php
require "./Initializer.php"; // On same folder to make tests faster

class Foo
{
    private $Bar;

    use ArrayInitializer;

    public function __toString()
    {
        return "This Foo's \$Bar is private, but i'll let you know it contais: $this->Bar";
    }
}

class Duwang
{
    public $Best;
    protected $Translation;

    use ObjectInitializer;

    public function __toString()
    {
        return "DUWANG is the best manga translation, check it out:
            - $this->Best
            - $this->Translation\n";
    }
}

$ArrayTest = new Foo([
    'Bar' => 'Some Value'
]);

$ObjectTest = new Duwang(new class {
    public $Best = 'Koichi steals!';
    public $Translation = 'No dignity!';
});

// Using __toString() in both objects to keep things simple.
echo "$ArrayTest;\n$ObjectTest";
```

The code above produces the following output:
```
This Foo's $Bar is private, but i'll let you know it contais: Some Value
DUWANG is the best manga translation, check it out:
            - Koichi steals!
            - No dignity!
```