# About
Cast request input in Laravel.

## Installation
`composer require nickescobedo/cambia`

## Basic Usage
1. Add `NickEscobedo\Cambia\CastRequestAttributes` trait to your request class.
1. Add a `casts` function to your request class that returns an array.
1. Access casts via request attributes `$request->attributes->get('inputKey')`. Note: The request key must have be validated in rules before it will attempt to cast.

## Example
```php
class Cast extends FormRequest
{
    use CastRequestAttributes;
    
    public function rules(): array
    {
        return [
            'toBoolean' => 'string', // Fields not present in validation will not cast
        ];
    }

    public function casts(): array
    {
        return [
            'toBoolean' => 'boolean',
        ];
    }
}
```
`$request->castedInput('toBoolean')` will return a boolean value.