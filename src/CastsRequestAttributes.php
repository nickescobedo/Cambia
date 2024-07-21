<?php

namespace NickEscobedo\Cambia;

use Illuminate\Http\Request;

/**
 * @template TGet
 */
interface CastsRequestAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  Request  $request
     * @param  string  $key
     * @param  mixed  $value
     * @param  array<string, mixed>  $attributes
     * @return TGet|null
     */
    public function get(Request $request, string $key, mixed $value, array $attributes);

}