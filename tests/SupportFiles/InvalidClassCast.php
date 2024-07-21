<?php

namespace NickEscobedo\Cambia\Tests\SupportFiles;

use Illuminate\Foundation\Http\FormRequest;
use NickEscobedo\Cambia\CastRequestAttributes;

class InvalidClassCast extends FormRequest
{
    use CastRequestAttributes;
    public function rules(): array
    {
        return [
            'invalidClassCastableJson' => 'string',
        ];
    }

    public function casts()
    {
        return [
            'invalidClassCastableJson' => InvalidJsonCast::class,
        ];
    }
}