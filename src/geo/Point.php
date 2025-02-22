<?php

namespace Grachamite\Polyterra\geo;

use Grachamite\Polyterra\exceptions\GeoErrors;
use Grachamite\Polyterra\validations\GeoValidator;

class Point
{
    private ?float $latitude = null;
    private ?float $longitude = null;

    private ?float $latitudeInRadians = null;
    private ?float $longitudeInRadians = null;

    private ?float $cosLatitude = null;
    private ?float $sinLatitude = null;


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

    public function getLatitude(bool $inRadians = false): float
    {
        // If point latitude not initialized,
        if ($this->isInitialized(['latitude']) === false ) {
            // Then throw exception
            GeoErrors::POINT_LATITUDE_NOT_INITIALIZED->throw();
        } else {
            // Else calculate latitude in radians (if it is not yet calculated)
            if ($inRadians && empty($this->latitudeInRadians)) {
                $this->latitudeInRadians = $this->latitude * pi() / 180;
            }

            // And returning point latitude in radians or in degrees
            return $inRadians ? $this->latitudeInRadians : $this->latitude;
        }
    }

    public function getCosLatitude(): float
    {
        // Calculate cos latitude (if it is not yet calculated)
        if (empty($this->cosLatitude)) {
            $this->cosLatitude = cos($this->getLatitude(inRadians: true));
        }

        // Returning cos latitude
        return $this->cosLatitude;
    }

    public function getSinLatitude(): float
    {
        // Calculate sin latitude (if it is not yet calculated)
        if (empty($this->sinLatitude)) {
            $this->sinLatitude = sin($this->getLatitude(inRadians: true));
        }

        // Returning sin latitude
        return $this->sinLatitude;
    }

    public function setLatitude(mixed $latitude)
    {
        // Validating latitude
        $validate = GeoValidator::isLatitude($latitude);

        // If latitude validated,
        if ($validate === true) {
            // Then unsetting latitude values
            $this->unsetLatitude();
            // And setting up latitude to point
            $this->latitude = (float) $latitude;
        } else {
            // Else throw exception
            GeoErrors::LATITUDE_VALIDATION_ERROR->throw();
        }
    }

    private function unsetLatitude(): void
    {
        unset(
            $this->latitude,
            $this->latitudeInRadians,
            $this->cosLatitude,
            $this->sinLatitude
        );
    }

    public function getLongitude(bool $inRadians = false): float
    {
        // If point longitude not initialized,
        if ($this->isInitialized(['longitude']) === false ) {
            // Then throw exception
            GeoErrors::POINT_LONGITUDE_NOT_INITIALIZED->throw();
        } else {
            // Else calculate longitude in radians (if it is not yet calculated)
            if ($inRadians && empty($this->longitudeInRadians)) {
                $this->longitudeInRadians = $this->longitude * pi() / 180;
            }

            // And returning point longitude in radians or in degrees
            return $inRadians ? $this->longitudeInRadians : $this->longitude;
        }
    }

    public function setLongitude(mixed $longitude): void
    {
        // Validating longitude
        $validate = GeoValidator::isLongitude($longitude);

        // If longitude validated,
        if ($validate === true) {
            // Then unsetting longitude values
            $this->unsetLongitude();
            // And setting up longitude to point
            $this->longitude = (float) $longitude;
        } else {
            // Else throw exception
            GeoErrors::LONGITUDE_VALIDATION_ERROR->throw();
        }
    }

    private function unsetLongitude(): void
    {
        unset(
            $this->longitude,
            $this->longitudeInRadians
        );
    }

    public function getCoordinates(bool $inRadians = false): array
    {
        try {
            $coordinates = [$this->getLatitude($inRadians), $this->getLongitude($inRadians)];
        } catch (\Exception $exception) {
            // then throw exception for point initialization
            GeoErrors::POINT_NOT_INITIALIZED->throw();
        }

        // else return coordinates
        return $coordinates;

    }

    public function setCoordinates()
    {
        // taking all function arguments
        $arguments = func_get_args();

        $argumentsType = GeoValidator::getCoordinatesType($arguments);
        // if coordinates in array,
        if ($argumentsType === GeoValidator::COORDINATES_IN_ARRAY) {
            // then taking latitude and longitude from array
            [$latitude, $longitude] = array_values($arguments[0]);
            // else if coordinates in list,
        } elseif ($argumentsType === GeoValidator::COORDINATES_IN_LIST) {
            // then taking coordinates from list
            [$latitude, $longitude] = array_values($arguments);
        } else {
            GeoErrors::INCORRECT_POINT_INITIALIZATION_ARGUMENT->throw();
        }

        // setting up coordinates for point
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }
}