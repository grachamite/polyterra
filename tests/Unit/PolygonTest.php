<?php

use Grachamite\Polyterra\exceptions\GeoErrors;
use Grachamite\Polyterra\exceptions\GeoValidationException;
use Grachamite\Polyterra\geo\Polygon;


test('successful initializing polygon', function (
    mixed $arguments, bool $expected
) {
    $polygon = new Polygon(...$arguments);
    $actual = $polygon->isInitialized();
    $this->assertEquals($expected, $actual);
})->with([
    'ordinary data in list' => [
        [11.12345678, 12.12345678, 12.12345678, 13.12345678, 11.62345678, 14.12345678],
        true
    ],
    'ordinary data in array' => [
        [[11.12345678, 12.12345678], [12.12345678, 13.12345678], [11.62345678, 14.12345678]],
        true
    ],
]);

test('initializing polygon with latitude validation error', function (
    mixed $arguments
) {
    new Polygon(...$arguments);
})->with([
    'incorrect latitude in point' => [
        [11.12345678, 12.12345678, 212.12345678, 13.12345678, 11.62345678, 14.12345678]
    ],
])->throws(exception: GeoValidationException::class, exceptionCode: GeoErrors::LATITUDE_VALIDATION_ERROR->value);

test('initializing polygon with longitude validation error', function (
    mixed $arguments
) {
    new Polygon(...$arguments);
})->with([
    'incorrect longitude in point' => [
        [[11.12345678, 12.12345678], [12.12345678, 213.12345678], [11.62345678, 14.12345678]]
    ],
])->throws(exception: GeoValidationException::class, exceptionCode: GeoErrors::LONGITUDE_VALIDATION_ERROR->value);


test('initializing polygon with argument validation error', function (
    mixed $arguments
) {
    new Polygon(...$arguments);
})->with([
    'odd arguments count' => [
        [11.12345678, 12.12345678, 212.12345678, 13.12345678, 11.62345678]
    ],

])->throws(exception: GeoValidationException::class, exceptionCode: GeoErrors::INCORRECT_POINT_INITIALIZATION_ARGUMENT->value);
