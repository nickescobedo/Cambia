<?php

namespace NickEscobedo\Cambia;

use RuntimeException;

class InvalidRequestCastException extends RuntimeException
{
    /**
     * The name of the request key.
     *
     * @var string
     */
    public $key;

    /**
     * The name of the cast type.
     *
     * @var string
     */
    public $castType;

    /**
     * Create a new exception instance.
     *
     * @param  string  $key
     * @param  string  $castType
     * @return void
     */
    public function __construct($key, $castType)
    {
        parent::__construct("Call to undefined cast [{$castType}] on request key [{$key}].");

        $this->key = $key;
        $this->castType = $castType;
    }
}
