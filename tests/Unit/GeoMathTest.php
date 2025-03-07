<?php

use Grachamite\Polyterra\math\GeoMath;
use Grachamite\Polyterra\geo\Point;

test('distance in km between', function (array $startPoint, array $endPoint , float $expected) {
    $actual = GeoMath::distance(new Point($startPoint), new Point($endPoint));

    $this->assertEquals($expected, $actual);
})->with([
    'from Saint-Petersburg to Petersburg' => [[59.938784, 30.314997], [59.938784, 30.314997], 0],
    'from Saint-Petersburg to Moscow' => [[59.938784, 30.314997], [55.755864, 37.617698], 634.361],
    'from Saint-Petersburg to Murmansk' => [[59.938784, 30.314997], [68.970663, 33.074918], 1013.011],
    'from London to Tokyo' => [[51.507351, -0.127696], [35.681729, 139.753927], 9564.461],
    'from New-York to Rio de Janeiro' => [[40.714627, -74.002863], [-22.905722, -43.189130], 7760.475],
]);

test('triangle area', function (array $aPoint, array $bPoint, array $cPoint, float $expected) {
    $actual = GeoMath::triangleArea(
        [
            new Point($aPoint), new Point($bPoint), new Point($cPoint)
        ]
    );

    $this->assertEquals($expected, $actual);
})->with([
    'New-York - London - Paris' => [[40.712800, -74.006000], [51.5074, -0.1278], [48.8566, 2.3522], 661458.136],
    'inside Saint-Petersburg' => [[59.945966, 30.235982], [59.947068, 30.283849], [59.933070, 30.252225], 1.976],
    'inside Murmansk' => [[68.975403, 33.066749], [68.956774, 33.055287], [68.961764, 33.105204], 1.93],
]);

