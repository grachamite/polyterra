<?php

namespace Grachamite\Polyterra\validations;

class GeoValidator
{
    /**
     * Validate latitude value
     * @param float $latitude
     * @return bool
     */
    public static function isLatitude(mixed $latitude): bool
    {
        return preg_match('/^[-]?((([0-8]?[0-9])(\.(\d{1,8}))?)|(90(\.0+)?))$/', $latitude) === 1;
    }

    /**
     * Validate longitude value
     * @param float $longitude
     * @return bool
     */
    public static function isLongitude(mixed $longitude): bool
    {
        return preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d{1,8}))?)|180(\.0+)?)$/', $longitude);
    }
}