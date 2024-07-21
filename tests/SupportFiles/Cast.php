<?php

namespace NickEscobedo\Cambia\Tests\SupportFiles;

use Illuminate\Foundation\Http\FormRequest;
use NickEscobedo\Cambia\CastRequestAttributes;

class Cast extends FormRequest
{
    use CastRequestAttributes;
    public function rules(): array
    {
        return [
            'toInt' => 'int',
            'toInteger' => 'integer',

            'toReal' => 'numeric',
            'toFloat' => 'numeric',
            'toDouble' => 'numeric',
            'toDecimal' => 'numeric',

            'toString' => 'numeric',

            'toBool' => 'string',
            'toBool2' => 'string',
            'toBoolean' => 'string',
            'toBoolean2' => 'string',

            'toObject' => 'string',

            'toArray' => 'string',
            'toJson' => 'string',

            'toCollection' => 'string',

            'toDate' => 'date',

            'toDateTime' => 'date',
            'toCustomDateTime' => 'date_format:Y-m-d H:s',

            'toImmutableDate' => 'date',

            'toImmutableDateTime' => 'date',
            'toImmutableCustomDateTime' => 'date',

            'toTimestamp' => 'date',

            'toEnum' => 'string',

            'classCastableJson' => 'string',
        ];
    }

    public function casts()
    {
        return [
            'toInt' => 'int',
            'toInteger' => 'integer',

            'toReal' => 'real',
            'toFloat' => 'float',
            'toDouble' => 'double',
            'toDecimal' => 'decimal:2',

            'toString' => 'string',

            'toBool' => 'boolean',
            'toBool2' => 'boolean',
            'toBoolean' => 'boolean',
            'toBoolean2' => 'boolean',

            'toObject' => 'object',

            'toArray' => 'array',
            'toJson' => 'json',

            'toCollection' => 'collection',

            'toDate' => 'date',

            'toDateTime' => 'datetime',
            'toCustomDateTime' => 'datetime:Y-m-d H:s',

            'toImmutableDate' => 'immutable_date',

            'toImmutableDateTime' => 'immutable_datetime',
            'toImmutableCustomDateTime' => 'immutable_datetime:Y-m-d H:s',

            'toTimestamp' => 'timestamp',

            'toEnum' => Status::class,

            'classCastableJson' => JsonCast::class,
        ];
    }
}