<?php

namespace Grachamite\Polyterra\validations;

class GeoValidator
{
    const COORDINATES_IN_ARRAY = 10;
    const COORDINATES_IN_LIST = 20;

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


    public static function getCoordinatesType(mixed $arguments): ?int
    {
        $argumentsCount = count($arguments);

        $isArray = count(array_filter($arguments, function ($arg) {
            return is_array($arg) && count($arg) >= 2;
        })) === $argumentsCount;

        $isEvenList = count(array_filter($arguments, function ($arg) {
                return ! is_array($arg);
            })) === $argumentsCount && floor($argumentsCount / 2) * 2 == $argumentsCount;

        if ($isArray) {
            return self::COORDINATES_IN_ARRAY;
        } elseif ($isEvenList) {
            return self::COORDINATES_IN_LIST;
        } else {
            return null;
        }

    }
}