<?php

namespace Grachamite\Polyterra\exceptions;

class PointLatitudeNotInitializedException extends \Exception
{
    protected $message = 'Point latitude not initialized';

    protected $code = 'point_latitude_not_initialized';
}