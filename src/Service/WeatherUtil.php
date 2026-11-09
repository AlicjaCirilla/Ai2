<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurment;
use App\Repository\MeasurmentRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;

class WeatherUtil
{
    /**
     * @return Measurment[]
     */
    public function __construct(private readonly LocationRepository $locationRepository, private readonly MeasurmentRepository $measurmentRepository){

    }
    public function getWeatherForLocation(Location $location): array
    {

        return $this->measurmentRepository->findByLocation($location);
        //return [];
    }

    /**
     * @return Measurment[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location= $this->locationRepository->findOneBy(['Country' => $countryCode, 'City' => $city]);

        if (!$location) {
            return [];
        }
        return $this->measurmentRepository->findByLocation($location);
    }
}
