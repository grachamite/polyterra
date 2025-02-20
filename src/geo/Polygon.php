<?php

namespace Grachamite\Polyterra\geo;

use Grachamite\Polyterra\exceptions\GeoErrors;
use Grachamite\Polyterra\validations\GeoValidator;

class Polygon
{
    const MIN_POINTS_COUNT = 3;
    private array $points = [];

    public function __construct()
    {
        $this->setPoints(...func_get_args());
    }

    public function isInitialized(): bool
    {
        return count($this->points) >= self::MIN_POINTS_COUNT;
    }
    public function setPoints()
    {
        $arguments = func_get_args();

        // Check arguments type for array
        $argumentsType = GeoValidator::getCoordinatesType($arguments);

        // If arguments not in list and arguments count even number,
        if ($argumentsType === GeoValidator::COORDINATES_IN_LIST) {
            // then split list to arrays with latitude and longitude,
            $arguments = array_chunk($arguments, 2);
        } elseif (is_null($argumentsType)) {
            GeoErrors::INCORRECT_POINT_INITIALIZATION_ARGUMENT->throw();
        }

        // Check argument count for minimum value
        $argumentsCount = count($arguments);
        $hasMinArgumentsCount = $argumentsCount >= self::MIN_POINTS_COUNT;

        if ($hasMinArgumentsCount === false) {
            // else throw argument exception
            GeoErrors::INCORRECT_POINT_INITIALIZATION_ARGUMENT->throw();
        }

        // Clear previous polygon points
        unset($this->points);

        // Create new points for polygon
        foreach ($arguments as $coordinates) {
            $this->points[] = new Point($coordinates);
        }
    }

}