<?php

namespace Grachamite\Polyterra\math;

use Grachamite\Polyterra\geo\Point;
use Grachamite\Polyterra\geo\Triangle;

class GeoMath
{
    const EARTH_RADIUS = 6372795;

    public static function distance(Point $startPoint, Point $endPoint, bool $inRadians = false): float
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

        return $inRadians ? round($ad, 10) : round($dist, 3);
    }

    public static function triangleArea(array $points): float
    {
        /* @var $aPoint Point */
        /* @var $bPoint Point */
        /* @var $cPoint Point */
        [$aPoint, $bPoint, $cPoint] = $points;

        // Spherical triangle sides
        $aLine = self::distance($bPoint, $cPoint, inRadians: true);
        $bLine = self::distance($cPoint, $aPoint, inRadians: true);
        $cLine = self::distance($aPoint, $bPoint, inRadians: true);

        // Spherical triangle angles
        $alpha = acos((cos($aLine) - cos($bLine) * cos($cLine)) / (sin($bLine) * sin($cLine)));
        $beta = acos((cos($bLine) - cos($aLine) * cos($cLine)) / (sin($aLine) * sin($cLine)));
        $gamma = acos((cos($cLine) - cos($aLine) * cos($bLine)) / (sin($aLine) * sin($bLine)));

        // Calculating spherical excess
        $excess = ($alpha + $beta + $gamma) - M_PI;

        // Calculating area
        $triangleArea = $excess * (self::EARTH_RADIUS ** 2);

        return round($triangleArea / 1000000, 3);
    }
}