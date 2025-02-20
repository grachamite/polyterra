<?php

namespace Grachamite\Polyterra\exceptions;

enum GeoErrors: int
{
    case UNKNOWN_ERROR = 0;
    case LATITUDE_VALIDATION_ERROR = 10;
    case LONGITUDE_VALIDATION_ERROR = 20;
    case POINT_LATITUDE_NOT_INITIALIZED = 30;
    case POINT_LONGITUDE_NOT_INITIALIZED = 40;
    case POINT_NOT_INITIALIZED = 50;

    public function throw(): void
    {
        match($this) {
            GeoErrors::UNKNOWN_ERROR => throw new GeoException(
               message: 'Unknown geo exception',
               code: GeoErrors::UNKNOWN_ERROR->value
           ),
            GeoErrors::LATITUDE_VALIDATION_ERROR => throw new GeoValidationException(
               message: 'Incorrect latitude',
               code: GeoErrors::LATITUDE_VALIDATION_ERROR->value
           ),
            GeoErrors::LONGITUDE_VALIDATION_ERROR => throw new GeoValidationException(
               message: 'Incorrect longitude',
               code: GeoErrors::LONGITUDE_VALIDATION_ERROR->value
           ),
            GeoErrors::POINT_LATITUDE_NOT_INITIALIZED => throw new GeoInitializeException(
                message: 'Point latitude not initialized',
                code: GeoErrors::POINT_LATITUDE_NOT_INITIALIZED->value
            ),
            GeoErrors::POINT_LONGITUDE_NOT_INITIALIZED => throw new GeoInitializeException(
                message: 'Point longitude not initialized',
                code: GeoErrors::POINT_LONGITUDE_NOT_INITIALIZED->value
            ),
            GeoErrors::POINT_NOT_INITIALIZED => throw new GeoInitializeException(
                message: 'Point not initialized',
                code: GeoErrors::POINT_NOT_INITIALIZED->value
            ),
        };
    }
}