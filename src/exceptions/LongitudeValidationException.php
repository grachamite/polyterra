<?php

namespace Grachamite\Polyterra\exceptions;

class LongitudeValidationException extends \Exception
{
    protected $message = 'Value not geo longitude';

    protected $code = 'longitude_validation_error';
}