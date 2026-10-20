<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\MeasurmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    //#[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    #[Route('/weather/{Country}/{City}', name: 'app_weather')]
//    public function city(Location $location, MeasurmentRepository $repository): Response
//    {
//        $measurements = $repository->findByLocation($location);
//
//        return $this->render('weather/city.html.twig', [
//            'location' => $location,
//            'measurements' => $measurements,
//        ]);
//    }
    public function city(Location $location, MeasurmentRepository $repository): Response
    {
        $measurements = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }

}
