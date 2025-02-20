<?php

use Grachamite\Polyterra\validations\GeoValidator;

test('latitude validator', function (mixed $latitude, bool $expected) {
    $actual = GeoValidator::isLatitude($latitude);
    $this->assertEquals($expected, $actual);
})->with([
    'ordinary latitude' => [11.12345678, true],
    'latitude too long' => [11.123456781, false],
    'short latitude' => [11.1234, true],
    'integer latitude' => [11, true],
    'string latitude' => ['11.12345678', true],
    'latitude too small' => [-90.00000001, false],
    'latitude too big' => [90.00000001, false],
]);

test('longitude validator', function (mixed $longitude, bool $expected) {
    $actual = GeoValidator::isLongitude($longitude);
    $this->assertEquals($expected, $actual);
})->with([
    'ordinary longitude' => [12.12345678, true],
    'longitude too long' => [12.123456781, false],
    'short longitude' => [12.1234, true],
    'integer longitude' => [12, true],
    'string longitude' => ['12.12345678', true],
    'longitude too small' => [-180.00000001, false],
    'longitude too big' => [180.00000001, false],
]);
