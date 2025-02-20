<?php

namespace Grachamite\Polyterra\exceptions;

class LatitudeValidationException extends \Exception
{
    protected $message = 'Value not geo latitude';

    protected $code = 'latitude_validation_error';
}