<?php

namespace Grachamite\Polyterra\exceptions;

class PointNotInitializedException extends \Exception
{
    protected $message = 'Point not initialized';

    protected $code = 'point_not_initialized';
}