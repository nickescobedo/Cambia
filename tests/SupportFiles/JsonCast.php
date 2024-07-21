<?php

namespace NickEscobedo\Cambia\Tests\SupportFiles;

use Illuminate\Http\Request;
use NickEscobedo\Cambia\CastsRequestAttributes;

class JsonCast implements CastsRequestAttributes
{

    /**
     * @inheritDoc
     */
    public function get(Request $request, string $key, mixed $value, array $attributes)
    {
        return json_decode($value, true);
    }
}