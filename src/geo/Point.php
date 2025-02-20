<?php

namespace Grachamite\Polyterra\geo;

use Grachamite\Polyterra\exceptions\LatitudeValidationException;
use Grachamite\Polyterra\exceptions\LongitudeValidationException;
use Grachamite\Polyterra\exceptions\PointNotInitializedException;
use Grachamite\Polyterra\exceptions\PointLatitudeNotInitializedException;
use Grachamite\Polyterra\exceptions\PointLongitudeNotInitializedException;
use Grachamite\Polyterra\validations\GeoValidator;

class Point
{
    private ?float $latitude = null;
    private ?float $longitude = null;
    const ALLOWED_INIT_PARAMS = [
        'latitude',
        'longitude'
    ];

    public function __construct()
    {
        // trying to initialize point with coordinates from arguments
        $this->setCoordinates(...func_get_args());
    }

    public function isInitialized(array $params = self::ALLOWED_INIT_PARAMS): bool
    {
        // Removing not allowed params
        $params = array_filter($params, function ($param) {
            return in_array($param, self::ALLOWED_INIT_PARAMS);
        });

        // Calculating initialized params
        $isInitialized = array_sum(array_map(function (string $param) {
            return (int) isset($this->{$param});
        }, $params));

        return $isInitialized > 0;
    }

    public function getLatitude(): float
    {
        // if point latitude not initialized,
        if ($this->isInitialized(['latitude']) === false ) {
            // then throw exception
            throw new PointLatitudeNotInitializedException();
        } else {
            // else returning point latitude
            return $this->latitude;
        }
    }

    public function setLatitude(mixed $latitude)
    {
        // validating latitude
        $validate = GeoValidator::isLatitude($latitude);

        // if latitude validated,
        if ($validate === true) {
            // then setting up latitude to point
            $this->latitude = (float) $latitude;
        } else {
            // else throw exception
            throw new LatitudeValidationException();
        }
    }

    public function getLongitude(): float
    {
        // if point longitude not initialized,
        if ($this->isInitialized(['longitude']) === false ) {
            // then throw exception
            throw new PointLongitudeNotInitializedException();
        } else {
            // else returning point longitude
            return $this->longitude;
        }
    }

    public function setLongitude(mixed $longitude)
    {
        // validating longitude
        $validate = GeoValidator::isLongitude($longitude);

        // if longitude validated,
        if ($validate === true) {
            // then setting up longitude to point
            $this->longitude = (float) $longitude;
        } else {
            // else throw exception
            throw new LongitudeValidationException();
        }
    }

    public function getCoordinates(): array
    {
        // if point not initialized (empty latitude, or longitude, or both),
        if ($this->isInitialized() === false ) {
            // then throw exception
            throw new PointNotInitializedException();
        } else {
            // else return coordinates
            return [$this->latitude, $this->longitude];
        }
    }

    public function setCoordinates()
    {
        // taking all function arguments
        $arguments = func_get_args();

        // if coordinates in array,
        if (isset($arguments[0]) && is_array($arguments[0]) && count($arguments[0]) >= 2) {
            // then taking latitude and longitude from array
            [$latitude, $longitude] = array_values($arguments[0]);
            // else if coordinates in list,
        } elseif (isset($arguments[0], $arguments[1])) {
            // then taking coordinates from list
            [$latitude, $longitude] = array_values($arguments);
        } else {
            throw new LatitudeValidationException();
        }

        // setting up coordinates for point
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }
}