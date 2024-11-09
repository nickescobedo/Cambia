<?php

namespace NickEscobedo\Cambia\Tests\SupportFiles;

use Illuminate\Foundation\Http\FormRequest;
use NickEscobedo\Cambia\CastRequestAttributes;

class AllInputCast extends FormRequest
{
    use CastRequestAttributes;
    public function rules(): array
    {
        return [
            'toInt' => 'int',
            'toString' => 'numeric',
            'toBool' => 'string',
            'toObject' => 'string',
        ];
    }

    public function casts()
    {
        return [
            'toInt' => 'int',
            'toString' => 'string',
            'toBool' => 'boolean',
            'toObject' => 'object',
        ];
    }
}