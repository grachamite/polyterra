<?php

namespace Grachamite\Polyterra\exceptions;

class PointLongitudeNotInitializedException extends \Exception
{
    protected $message = 'Point longitude not initialized';

    protected $code = 'point_longitude_not_initialized';
}