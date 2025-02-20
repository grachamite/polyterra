<?php

use Grachamite\Polyterra\exceptions\GeoErrors;
use Grachamite\Polyterra\exceptions\GeoInitializeException;
use Grachamite\Polyterra\exceptions\GeoValidationException;
use Grachamite\Polyterra\geo\Point;


test('successful initializing point', function (
    mixed $latitude, mixed $longitude, bool $inArray, bool $expected
) {
    if ($inArray === true) {
        $point = new Point([$latitude, $longitude]);
    } else {
        $point = new Point($latitude, $longitude);
    }

    $actual = $point->isInitialized();

    $this->assertEquals($expected, $actual);
})->with([
    'ordinary data in list' => [11.12345678, 12.12345678, false, true],
    'ordinary data in array' => [11.12345678, 12.12345678, true, true],
]);


test('initializing point with latitude validation error', function (
    mixed $latitude, mixed $longitude, bool $inArray
) {
    if ($inArray === true) {
        new Point([$latitude, $longitude]);
    } else {
        new Point($latitude, $longitude);
    }
})->with([
    'incorrect latitiude in list' => [11.123456782, 12.12345678, false],
    'incorrect latitiude in array' => [211.12345678, 12.12345678, true],
])->throws(exception: GeoValidationException::class, exceptionCode: GeoErrors::LATITUDE_VALIDATION_ERROR->value);


test('initializing point with longitude validation error', function (
    mixed $latitude, mixed $longitude, bool $inArray
) {
    if ($inArray === true) {
        new Point([$latitude, $longitude]);
    } else {
        new Point($latitude, $longitude);
    }
})->with([
    'incorrect longitude in list' => [11.12345678, 12.123456782, false],
    'incorrect longitude in array' => [11.12345678, 212.12345678, true],
])->throws(exception: GeoValidationException::class, exceptionCode: GeoErrors::LONGITUDE_VALIDATION_ERROR->value);

