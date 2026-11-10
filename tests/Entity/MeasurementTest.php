<?php

namespace App\Tests\Entity;

use App\Entity\Measurment;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['21.37','70.466'],
            ['69.96','157.928'],
            ['40','104'],
            ['80','176'],
            ['21','69.8'],
            ['37','98.6'],
            ['91','195.8'],
        ];
    }
    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $inputcelsius, string $expectedFahrenheit): void
    {
        $celsius= new Measurment();
        $celsius->setTemperature($inputcelsius);

        $this -> assertEquals($expectedFahrenheit, $celsius->getFahrenheit());

//
//        $celsius->setTemperature(-100);
//        $this -> assertEquals(-148, $celsius->getFahrenheit());
//
//        $celsius->setTemperature(100);
//        $this -> assertEquals(212, $celsius->getFahrenheit());
    }
}
