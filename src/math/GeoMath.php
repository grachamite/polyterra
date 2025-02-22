<?php

namespace Grachamite\Polyterra\math;

use Grachamite\Polyterra\geo\Point;

class GeoMath
{
    const EARTH_RADIUS = 6372795;

    public static function distance(Point $startPoint, Point $endPoint): float
    {
        // Calculating cosines for points latitudes
        $cosLatitudeStartPoint = $startPoint->getCosLatitude();
        $cosLatitudeEndPoint = $endPoint->getCosLatitude();

        // Calculating sinuses for points latitudes
        $sinLatitudeStartPoint = $startPoint->getSinLatitude();
        $sinLatitudeEndPoint = $endPoint->getSinLatitude();

        // Calculating delta
        $delta = ($endPoint->getLongitude(inRadians: true) - $startPoint->getLongitude(inRadians: true));
        $cosDelta = cos($delta);
        $sinDelta = sin($delta);

        // Calculating distance
        $y = sqrt(pow($cosLatitudeEndPoint * $sinDelta, 2)
            + pow($cosLatitudeStartPoint * $sinLatitudeEndPoint - $sinLatitudeStartPoint * $cosLatitudeEndPoint * $cosDelta, 2));
        $x = $sinLatitudeStartPoint * $sinLatitudeEndPoint + $cosLatitudeStartPoint * $cosLatitudeEndPoint * $cosDelta;

        $ad = atan2($y, $x);
        $dist = $ad * self::EARTH_RADIUS / 1000;

        return round($dist, 3);
    }
}