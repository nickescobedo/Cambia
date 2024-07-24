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

## Available Casts
- int
- integer
- float
- double
- decimal
- string
- boolean
- object
- array
- json
- collection
- date
- datetime
- immutable_date
- immutable_datetime
- timestamp


## Custom Casts
Custom casts allow for more complex casting logic. Enums and custom classes can be used. Custom cast classes must implement `NickEscobedo\Cambia\CastsRequestAttributes`.

### Enum
```php
enum Status: string
{
    case Pending = 'pending';
}
```
```php
public function casts(): array
{
    return [
        'status' => Status::class,
    ];
}
```

### Custom Cast Class
The class must implement `NickEscobedo\Cambia\CastsRequestAttributes`.
```php
use Illuminate\Http\Request;
use NickEscobedo\Cambia\CastsRequestAttributes;

class JsonCast implements CastsRequestAttributes
{

    public function get(Request $request, string $key, mixed $value, array $attributes)
    {
        return json_decode($value, true);
    }
}
```
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
            'toBoolean' => JsonCast::class,
        ];
    }
}
```